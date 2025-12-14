#!/usr/bin/env python3
"""Generate captions via OpenAI Whisper API or local whisper.cpp."""
import argparse
import os
import subprocess
import tempfile
from pathlib import Path

import requests

OPENAI_API_URL = "https://api.openai.com/v1/audio/transcriptions"


def transcribe_api(file_path: Path, model: str, language: str | None, response_format: str) -> str:
    api_key = os.getenv("OPENAI_API_KEY")
    if not api_key:
        raise RuntimeError("OPENAI_API_KEY not set")
    with file_path.open("rb") as fh:
        files = {"file": (file_path.name, fh, "application/octet-stream")}
        data = {"model": model, "response_format": response_format}
        if language:
            data["language"] = language
        response = requests.post(
            OPENAI_API_URL,
            headers={"Authorization": f"Bearer {api_key}"},
            data=data,
            files=files,
            timeout=300,
        )
    if response.status_code != 200:
        raise RuntimeError(f"API failed ({response.status_code}): {response.text}")
    return response.text


def transcribe_whisper_cpp(file_path: Path, whisper_bin: Path, model_path: Path, language: str | None, response_format: str) -> str:
    if response_format not in {"srt", "vtt", "text"}:
        raise RuntimeError("whisper.cpp supports srt/vtt/text only")

    with tempfile.TemporaryDirectory() as tmpdir:
        out_file = Path(tmpdir) / f"out.{response_format}"
        cmd = [
            str(whisper_bin),
            "-f", str(file_path),
            "-ot", response_format,
            "-m", str(model_path),
            "-of", str(out_file.with_suffix(""))
        ]
        if language:
            cmd += ["-l", language]
        subprocess.run(cmd, check=True)
        return out_file.read_text(encoding="utf-8")


def main():
    parser = argparse.ArgumentParser(description="Generate captions via OpenAI API or whisper.cpp")
    parser.add_argument("inputs", nargs="+", help="Audio/video files")
    parser.add_argument("--format", default="srt", choices=["srt", "vtt", "text"], help="Caption format")
    parser.add_argument("--language", help="Language hint")
    parser.add_argument("--model", default="whisper-1", help="OpenAI model ID")
    parser.add_argument("--out-dir", default="captions", help="Output directory")
    parser.add_argument("--whisper-bin", help="Path to whisper.cpp binary")
    parser.add_argument("--whisper-model", help="Path to GGML/GGUF model for whisper.cpp")
    args = parser.parse_args()

    out_dir = Path(args.out_dir)
    out_dir.mkdir(parents=True, exist_ok=True)

    use_local = args.whisper_bin and args.whisper_model
    for input_path in args.inputs:
        source = Path(input_path)
        if not source.exists():
            print(f"Missing: {source}")
            continue
        print(f"Transcribing {source} via {'whisper.cpp' if use_local else 'OpenAI API'}...")
        try:
            if use_local:
                transcript = transcribe_whisper_cpp(source, Path(args.whisper_bin), Path(args.whisper_model), args.language, args.format)
            else:
                transcript = transcribe_api(source, args.model, args.language, args.format)
        except Exception as exc:
            print(f"  Failed: {exc}")
            continue
        suffix = ".txt" if args.format == "text" else f".{args.format}"
        output_file = out_dir / (source.stem + suffix)
        output_file.write_text(transcript, encoding="utf-8")
        print(f"  Saved -> {output_file}")


if __name__ == "__main__":
    main()
