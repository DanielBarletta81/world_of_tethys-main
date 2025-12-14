#!/usr/bin/env python3
"""Utility to pull large media assets from the private S3 bucket.

Usage:
  python scripts/download_media.py --groups site-audio theme-audio
  python scripts/download_media.py --all

Requires AWS creds in environment (see .env) and boto3 installed.
"""
from __future__ import annotations

import argparse
import os
from pathlib import Path
from typing import Iterable, Dict, Any

import boto3
from botocore.exceptions import ClientError

MEDIA_BUCKET = os.environ.get("MEDIA_BUCKET")
AWS_REGION = os.environ.get("AWS_REGION", "us-east-1")

MEDIA_GROUPS: Dict[str, Dict[str, Any]] = {
    "site-audio": {
        "description": "Public site audio masters (public/audio)",
        "type": "prefix",
        "prefix": "media/public/audio",
        "dest": "public/audio",
    },
    "theme-audio": {
        "description": "WordPress theme audio kit (tethys-theme/audio_extended)",
        "type": "prefix",
        "prefix": "media/tethys-theme/audio_extended",
        "dest": "tethys-theme/audio_extended",
    },
    "audio-projects": {
        "description": "Root audio project files (audio/)",
        "type": "prefix",
        "prefix": "media/audio",
        "dest": "audio",
    },
    "archives": {
        "description": "Theme ZIP exports",
        "type": "objects",
        "objects": {
            "archives/tethys-theme-2.zip": "tethys-theme 2.zip",
            "archives/tethys-theme-3.zip": "tethys-theme 3.zip",
            "archives/tethys-theme-latest.zip": "tethys-theme-latest.zip",
        },
    },
}


def parse_args() -> argparse.Namespace:
    parser = argparse.ArgumentParser(description="Download media assets from S3")
    parser.add_argument(
        "--groups",
        nargs="+",
        choices=sorted(MEDIA_GROUPS.keys()),
        help="Specific media groups to download (default: --all)",
    )
    parser.add_argument(
        "--all",
        action="store_true",
        help="Download every defined media group",
    )
    return parser.parse_args()


def ensure_bucket_configured() -> None:
    if not MEDIA_BUCKET:
        raise SystemExit("MEDIA_BUCKET is not set. Check your .env file.")


def ensure_dest(path: Path) -> None:
    path.mkdir(parents=True, exist_ok=True)


def download_prefix(s3, bucket: str, prefix: str, dest: Path) -> None:
    paginator = s3.get_paginator("list_objects_v2")
    total = 0
    for page in paginator.paginate(Bucket=bucket, Prefix=prefix):
        for obj in page.get("Contents", []):
            key = obj["Key"]
            rel = key[len(prefix):].lstrip("/")
            if not rel:
                continue
            target = dest / rel
            target.parent.mkdir(parents=True, exist_ok=True)
            print(f"⬇️  {key} -> {target}")
            s3.download_file(bucket, key, str(target))
            total += 1
    if total == 0:
        print(f"⚠️  No objects found under prefix {prefix}")


def download_objects(s3, bucket: str, mapping: Dict[str, str]) -> None:
    for key, dest in mapping.items():
        target = Path(dest)
        target.parent.mkdir(parents=True, exist_ok=True)
        print(f"⬇️  {key} -> {target}")
        s3.download_file(bucket, key, str(target))


def run(groups: Iterable[str]) -> None:
    ensure_bucket_configured()
    session = boto3.session.Session(region_name=AWS_REGION)
    s3 = session.client("s3")
    for group in groups:
        meta = MEDIA_GROUPS[group]
        print(f"\n=== Downloading {group}: {meta['description']} ===")
        if meta["type"] == "prefix":
            ensure_dest(Path(meta["dest"]))
            download_prefix(s3, MEDIA_BUCKET, meta["prefix"], Path(meta["dest"]))
        elif meta["type"] == "objects":
            download_objects(s3, MEDIA_BUCKET, meta["objects"])
        else:
            raise ValueError(f"Unknown media group type: {meta['type']}")


def main() -> None:
    args = parse_args()
    groups = args.groups
    if args.all or not groups:
        groups = MEDIA_GROUPS.keys()
    try:
        run(groups)
    except ClientError as exc:
        raise SystemExit(f"Failed to download media: {exc}")


if __name__ == "__main__":
    main()
