# World of Tethys Audio

The heavy audio renders live in the private `world-of-tethys-media-bucket`.
Restore them locally with:

```bash
pip install boto3  # first time only
export $(cat .env | xargs)  # or use direnv
python scripts/download_media.py --groups site-audio
```

That command hydrates `public/audio` with every MP3/WAV/REAPER file. Keep this
folder out of Git—run the download script whenever you need the assets.
