#!/usr/bin/env python3
"""
Signal Ping: tiny CLI warm-up set inside the World of Tethys universe.

You have six scans to identify which region a rogue signal is bouncing from.
Each guess surfaces a hint that narrows the biome or faction responsible.
"""
from __future__ import annotations

import random

SIGNAL_SOURCES = [
    ("Mystic Woods canopy", "Sap-slick echoes and chittering gliders."),
    ("Sky City underbelly", "Metallic hum mixed with coolant drip."),
    ("Watcher outpost", "Disciplined cadence with beacon pings every five beats."),
    ("Ashfall dunes", "Dry crackle, distant thunder, and glassed sand crunch."),
    ("Thal fishing raft", "Water slap, gull screech, and braided rope groans."),
]

TRIES = 6


def main() -> None:
    answer, clue = random.choice(SIGNAL_SOURCES)
    print("=== Signal Ping ===")
    print("Trace the rogue transmission before the predator triangulates you.")
    print(f"You get {TRIES} scans. Regions in play:")
    for name, _ in SIGNAL_SOURCES:
        print(f" - {name}")

    for attempt in range(1, TRIES + 1):
        guess = input(f"\nScan #{attempt}: ").strip()
        if not guess:
            print("  » Need a region name to lock the scan.")
            continue

        if guess.lower() == answer.lower():
            print("  » Link secured. You routed the signal before it went dark.")
            return

        print("  » Static. Not a match.")
        if attempt in (2, 4):
            print(f"    Hint: {clue}")

    print("\nSignal lost. Predators have the bead.")
    print(f"It originated from: {answer}")


if __name__ == "__main__":
    main()
