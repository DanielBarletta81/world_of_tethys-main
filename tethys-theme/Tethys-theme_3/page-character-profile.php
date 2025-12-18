<?php
/*
Template Name: Tethys Character Profile
Description: Reusable detail page for the main characters. Create child pages under /characters/{slug}/ and apply this template.
*/

get_header();

$slug = get_post_field('post_name', get_post());

$characters = [
    'igzier' => [
        'name' => 'Igzier',
        'tagline' => 'Sky City · Exile',
        'status' => 'Engineer · POV · Season One',
        'quote' => '“The City is a nervous system with bad routing. I just stopped lying about the sparks.”',
        'summary' => 'Mixed-lineage engineer who treats Sky City like a system on a slab. Refused to falsify the report on his mentor’s “natural” death and was thrown from the Weep for telling the truth. Numbers-first, heart-late, still deciding if the City deserves saving or burning.',
        'stats' => [
            ['label' => 'Bond', 'value' => 'Stryker · Ashwing sky-hound'],
            ['label' => 'Signature', 'value' => 'Ashwing gauntlet etched in copper'],
            ['label' => 'Edge', 'value' => 'Systems intuition + exile grit'],
            ['label' => 'Weak link', 'value' => 'He trusts math more than people']
        ],
        'notables' => [
            'Exiled by choice instead of accepting “The Quick.”',
            'Carries Melden’s holo-slate with corrupted schematics.',
            'Keeps a hidden ledger of Sky City failures in cipher.'
        ],
        'secrets' => [
            'Sky City dossier labels him “Asset 7C: volatile but trackable.”',
            'His exile drop coordinates were altered minutes before launch.',
            'Still receives anonymous data pings from the upper tiers.'
        ],
        'glyph' => 'ashwing-glyph.svg',
        'social' => [
            'handle' => '@Igz',
            'music' => 'Root-hum / world-beat mixes',
            'mood'  => 'Online · “Mapping fractures.”',
            'location' => 'Sky City ledge network',
            'signal' => 'Field rig + holo-slate rebuild stream'
        ],
        'comments' => [
            ['author' => 'LedgeWatcher', 'text' => 'Rootroom says you rerouted half the vents from a ledge. Confirm?'],
            ['author' => 'ArchivistSaela', 'text' => 'Your math is reckless but necessary. Keep sending the cracks.'],
            ['author' => 'AshwingFan', 'text' => 'Drop the cipher pages when? The City is literally shaking.']
        ]
    ],
    'stryker' => [
        'name' => 'Stryker',
        'tagline' => 'Ashwing · Bonded creature',
        'status' => 'Ptero–raptor sky-hound',
        'quote' => 'The way he tilts his skull is the only warning you get.',
        'summary' => 'Ashwing bond-beast who swan-dived after Igzier during the exile drop, then lost him in ashfall when Watcher stirred. Moose-sized, scarred, convinced he is still a lap pet and the only one allowed to drag Igzier home.',
        'stats' => [
            ['label' => 'Wing span', 'value' => '14 meters (ragged)'],
            ['label' => 'Primary sense', 'value' => 'Low frequency hum tracking'],
            ['label' => 'Bond mark', 'value' => 'Copper rings along crest'],
            ['label' => 'Temper', 'value' => 'Protective → feral in 2 beats']
        ],
        'notables' => [
            'Built for gliding, diving, and reckless rescues.',
            'Tracks Igzier through caves, shelves, and ash storms.',
            'Center of the Ashwing sigil carved across exile kits.'
        ],
        'secrets' => [
            'Ashwing rookery kept a black box of his vocal patterns.',
            'Responds to a whistle sequence Melden encoded for Igzier.',
            'Knows at least three routes back into the City vents.'
        ],
        'glyph' => 'ashwing-glyph.svg',
        'social' => [
            'handle' => '@AshwingStryke',
            'music' => 'Storm percussion / wing-beat bass',
            'mood' => 'Tracking Igz · scarred but stubborn',
            'location' => 'Cliff thermals over the Tethys Sea',
            'signal' => 'Live talon-cam + screech translations'
        ],
        'comments' => [
            ['author' => 'ChasmScout', 'text' => 'I heard you had burned wings, Stryker—how did that impact your flight and search?'],
            ['author' => 'SkyCityKids', 'text' => 'You are a BEAST 🐉🔥 keep slicing the storms!'],
            ['author' => 'WatcherInTraining', 'text' => 'Teach me that double-dive? Asking for a friend (me).']
        ]
    ],
    'ravel' => [
        'name' => 'Ravel',
        'tagline' => 'Mystic Woods · Healer',
        'status' => 'Field medic · Trail listener',
        'quote' => '“Roots tell you who fell. You just have to hear the bruise.”',
        'summary' => 'Tea-drunk forest healer who hears color, tone, and bruises in the air instead of warnings. Quietly decides Igzier is worth keeping alive, even if it means translating the Mystic Woods for a Sky City exile.',
        'stats' => [
            ['label' => 'Discipline', 'value' => 'Trail hum cartography'],
            ['label' => 'Companion', 'value' => 'Secretive archaeopteryx'],
            ['label' => 'Focus', 'value' => 'Mono-string instrument + fungi tonics'],
            ['label' => 'Risk', 'value' => 'Will trade blood for answers']
        ],
        'notables' => [
            'Calls the Weep “screaming in cracked teal.”',
            'Translates seismic pulses into melodies.',
            'Keeps a ledger of every exile the Woods kept breathing.'
        ],
        'secrets' => [
            'Carries a sealed blossom from the Weep as insurance.',
            'Has a coil cipher that opens the Watcher’s route stones.',
            'Knows the true price the Woods demand for sanctuary.'
        ],
        'glyph' => 'younger-woods-glyph.svg',
        'social' => [
            'handle' => '@RootListener',
            'music' => 'Mono-string drones + forest hum',
            'mood' => 'Quiet / tuned to the Younger Wood',
            'location' => 'Halfway ledges · fungus clinic',
            'signal' => 'Field notes + weird plant selfies'
        ],
        'comments' => [
            ['author' => 'Screecher77', 'text' => 'Did the Younger Wood really archive voices? I felt them when I passed through.'],
            ['author' => 'FeralMedic', 'text' => 'Your bone tea kept my bond running. Sending spores in thanks!'],
            ['author' => 'Igz', 'text' => 'Still owe you three ledge dinners. Hold me to it.']
        ]
    ],
    'karys' => [
        'name' => 'Karys',
        'tagline' => 'Sky City · Greenhouse heir',
        'status' => 'Politic botanist · POV',
        'quote' => '“Pipes crack where policy does. I just map both.”',
        'summary' => 'Greenhouse heir who maps roots and water flow while the Triumvirate edits reality. Tied to comfort by family, tied to change by conscience, and one of the hands on the City’s scale.',
        'stats' => [
            ['label' => 'Specialty', 'value' => 'Hydro lattice modeling'],
            ['label' => 'Signature artifact', 'value' => 'Seed-linked bracelets'],
            ['label' => 'Allegiance', 'value' => 'Split between Lady Eldora and Igzier'],
            ['label' => 'Cipher clearance', 'value' => 'Level Verdant (secret)']
        ],
        'notables' => [
            'Sees where pipes—and policies—crack.',
            'Keeps contraband root-scan scrolls in her cuff walls.',
            'Maintains the vault that feeds the City’s myth.'
        ],
        'secrets' => [
            'Triumvirate dossier tags her as “Potential Dissident A.”',
            'Stores a “fail-safe bloom” keyed to Igzier’s biometrics.',
            'Has already bribed a Watcher archivist for exile data.'
        ],
        'glyph' => 'greenhouse-glyph.svg',
        'social' => [
            'handle' => '@KarysSkyCity',
            'music' => 'Glass-harp / rainfall loops',
            'mood' => 'Calm surface · rebellious core',
            'location' => 'Upper greenhouse tiers',
            'signal' => 'Hydro lattice diagrams + covert posts'
        ],
        'comments' => [
            ['author' => 'Tier2Archivist', 'text' => 'Your latest water models leaked. They look like rebellion.'],
            ['author' => 'Saela', 'text' => 'Your bracelets hummed when the Watch passed. Protection spell?'],
            ['author' => 'Igz', 'text' => 'Stay above the floodline. I’ll fix the rest.']
        ]
    ],
    'melden' => [
        'name' => 'Melden',
        'tagline' => 'Sky City · Mentor (deceased)',
        'status' => 'Systems scientist · Echo',
        'quote' => '“It’s still an experiment, even if they call it destiny.”',
        'summary' => 'Scientist who insisted Sky City was an experiment, not a miracle. His “natural” death and Igzier’s refusal to lie about it light the fuse.',
        'stats' => [
            ['label' => 'Field', 'value' => 'Systems ethics + coil arrays'],
            ['label' => 'Legacy asset', 'value' => 'Corrupted holo-slate'],
            ['label' => 'Hidden ally', 'value' => 'Watcher clerk – codename Nacre'],
            ['label' => 'Status', 'value' => 'Dead, but everywhere in Igzier’s choices']
        ],
        'notables' => [
            'Documented the experiment’s failure modes.',
            'Framed survival as chance colliding with rules.',
            'Smuggled data out via Ashwing rookery twins.'
        ],
        'secrets' => [
            'Left a posthumous lockbox in the Greenhouse cistern.',
            'Triumvirate erased his civic ID but not his ghost ciphers.',
            'His final note references “Project Varek.”'
        ],
        'glyph' => 'mentor-glyph.svg',
        'social' => [
            'handle' => '@MeldenGhost',
            'music' => 'Analog synth archives',
            'mood' => 'Echo logged · always observing',
            'location' => 'Shadow backups in the vents',
            'signal' => 'Scheduled drops of ethics notes'
        ],
        'comments' => [
            ['author' => 'WatcherNacre', 'text' => 'Your last directive auto-posted. I’m still parsing it.'],
            ['author' => 'Igz', 'text' => 'You were right about the Cohort. Working on repairs.'],
            ['author' => 'TriumvirateBot', 'text' => 'This account is under investigation.'],
        ]
    ],
    'varek' => [
        'name' => 'Varek',
        'tagline' => 'Sky City · Shadow cartographer',
        'status' => 'Coil runner · Classified',
        'quote' => 'Files list him as rumor. Rumor keeps the vents open.',
        'summary' => 'The rumor assigned to carve safe corridors between tiers. Appears in redacted Watcher summaries and in the whispered routes Igzier now travels.',
        'stats' => [
            ['label' => 'Role', 'value' => 'Shadow cartographer'],
            ['label' => 'Alias', 'value' => 'Asset 22-F'],
            ['label' => 'Tool', 'value' => 'Multi-tier resonance map'],
            ['label' => 'Status', 'value' => 'Unconfirmed, but his work remains']
        ],
        'notables' => [
            'Leaves chalk sigils only Ashwing bonds can see.',
            'Sells false maps to the Triumvirate to hide true routes.',
            'Rumored to owe Igzier a life-debt.'
        ],
        'secrets' => [
            'Connected to Melden’s “Project Varek.”',
            'Possesses a rootbond key stolen from Lady Eldora.',
            'Maintains a hidden room inside the City’s central vent.'
        ],
        'glyph' => 'shadow-glyph.svg',
        'social' => [
            'handle' => '@VarekRoutes',
            'music' => 'Metallic echo + coil static',
            'mood' => 'Ghosting the Watchers',
            'location' => 'Where vents hum at 63 Hz',
            'signal' => 'Map fragments + scrambled coordinates'
        ],
        'comments' => [
            ['author' => 'ChalkRunner', 'text' => 'Saw your sigil near the lower lifts. Safe to follow?'],
            ['author' => 'AshWinged', 'text' => 'Drop a new route south, the ledges are crowded.'],
            ['author' => 'WatcherAudit', 'text' => 'We can still see you. Maybe.']
        ]
    ],
    'herc' => [
        'name' => 'Herc',
        'tagline' => 'Tethys Sea · Beast handler',
        'status' => 'Sea mammoth wrangler',
        'quote' => '“Nothing that big should listen. But they do—until the storms.”',
        'summary' => 'Keeps prehistoric mammoths docile and has opinions about humans who try to ride storms. Acts as the blunt counterweight to Sky City arrogance.',
        'stats' => [
            ['label' => 'Stronghold', 'value' => 'Danian salt barges'],
            ['label' => 'Specialty', 'value' => 'Storm harness rigging'],
            ['label' => 'Ally', 'value' => 'Kel the blockade runner'],
            ['label' => 'Totem', 'value' => 'Bone hook carved with tides']
        ],
        'notables' => [
            'Runs illicit courier routes beneath the blockade.',
            'Trains mammoths to drag down failing Sky City drones.',
            'Has a standing debt with the Mystic Woods healers.'
        ],
        'secrets' => [
            'Hid Igzier in a salt cyst during the first exile chase.',
            'Knows the identity of the Watcher who sabotaged the Weep.',
            'Keeps a ledger of City buyers paying for black-market storms.'
        ],
        'glyph' => 'sea-glyph.svg',
        'social' => [
            'handle' => '@HercOnTheTide',
            'music' => 'Bone drum + whale beat',
            'mood' => 'Salty / amused / armed',
            'location' => 'Danian barges and storm lanes',
            'signal' => 'Mammoth cam + weather rants'
        ],
        'comments' => [
            ['author' => 'KelRunner', 'text' => 'Storm rig held! Sending you rum + parts.'],
            ['author' => 'SeaByline', 'text' => 'Need that story about the drone you netted.'],
            ['author' => 'SkyKid', 'text' => 'Teach me how to steer a mammoth??']
        ]
    ],
    'saela' => [
        'name' => 'Saela (formerly Cali-Rai)',
        'tagline' => 'Sky City · Whisper archivist',
        'status' => 'Cipher keeper · Alias: Saela',
        'quote' => '“Names flex. Secrets don’t.”',
        'summary' => 'The archivist who rebranded herself after erasing her original identity from the Triumvirate ledgers. Deals in whispers, symbology, and coded allegiances.',
        'stats' => [
            ['label' => 'Discipline', 'value' => 'Symbology + covert comms'],
            ['label' => 'Archive clearance', 'value' => 'Obsidian tier'],
            ['label' => 'Bond', 'value' => 'Cryptic messages to Karys'],
            ['label' => 'Mask', 'value' => 'Ribboned veil with embedded glyphs']
        ],
        'notables' => [
            'Renamed herself Saela to disappear in plain sight.',
            'Speaks in layered metaphors Sky City can’t parse.',
            'Maintains the symbol ledger for the Watchers.'
        ],
        'secrets' => [
            'Runs a clandestine hotline for exiles still inside the City.',
            'Owns the only working mirror-loom outside the Triumvirate.',
            'Recorded Melden’s true confession before his death.'
        ],
        'glyph' => 'whisper-glyph.svg',
        'social' => [
            'handle' => '@SaelaGlyph',
            'music' => 'Encrypted choirs',
            'mood' => 'Whispering in layers',
            'location' => 'Archivist vaults',
            'signal' => 'Symbol drops + clandestine polls'
        ],
        'comments' => [
            ['author' => 'VerdantClerk', 'text' => 'Your last symbol flashed over the cistern. Intentional?'],
            ['author' => 'Karys', 'text' => 'I decoded the ribbon. Message received.'],
            ['author' => 'TriumvirateBot', 'text' => 'This thread is under moderation.']
        ]
    ],
    'jairo' => [
        'name' => 'Jairo',
        'tagline' => 'Sky City · Infrastructure',
        'status' => 'Water records steward',
        'quote' => '“Pipes don’t lie. People do.”',
        'summary' => 'Lower-tier lifer who keeps the water flowing and the records clean. Wants to believe the City is fixable… until the cracks stop being theoretical.',
        'stats' => [
            ['label' => 'Role', 'value' => 'Infrastructure analyst'],
            ['label' => 'Bond', 'value' => 'Childhood ally · Igzier'],
            ['label' => 'Tool', 'value' => 'Contraband hydro cipher'],
            ['label' => 'Status', 'value' => 'Watched by Triumvirate auditors']
        ],
        'notables' => [
            'Mixed-lineage, too sharp for his assigned slot.',
            'Keeps a side ledger of unreported pipe ruptures.',
            'Torn between loyalty to Igzier and survival.'
        ],
        'secrets' => [
            'Smuggled Ashwing telemetry down to Igzier pre-exile.',
            'Embedded a kill-switch in the City’s water tax algorithm.',
            'Triumvirate lists him as “Asset under reconsideration.”'
        ],
        'glyph' => 'infrastructure-glyph.svg',
        'social' => [
            'handle' => '@JairoRecords',
            'music' => 'Pipe resonance + low brass',
            'mood' => '“I’m fine.” (He isn’t.)',
            'location' => 'Water archives, tier 3',
            'signal' => 'Leak reports + survival memes'
        ],
        'comments' => [
            ['author' => 'PipeTech44', 'text' => 'Your leak log saved three tiers. Drinks on me.'],
            ['author' => 'Igz', 'text' => 'Hold the lines. I’m coming back for all of you.'],
            ['author' => 'WatcherAudit', 'text' => 'Reminder: unauthorized ledgers are illegal.']
        ]
    ],
    'maros' => [
        'name' => 'Maros',
        'tagline' => 'Sky City · Quiet enforcer',
        'status' => 'Watcher liaison',
        'quote' => '“Every exile is a test signal.”',
        'summary' => 'The Watcher liaison who smiles in public and writes kill orders in private. Rarely seen, often suspected, always listening.',
        'stats' => [
            ['label' => 'Assignment', 'value' => 'Exile observation'],
            ['label' => 'Weapon', 'value' => 'Silica filament garrote'],
            ['label' => 'Tell', 'value' => 'Clicks tongue before lying'],
            ['label' => 'Status', 'value' => 'Officially “on leave”']
        ],
        'notables' => [
            'Shadowed Igzier’s exile drop from the upper decks.',
            'Feeds false intel to the Watcher council.',
            'Keeps trophies from failed bond experiments.'
        ],
        'secrets' => [
            'Owns a vault of confiscated Ashwing feathers.',
            'Communicates with Varek through mirror knocks.',
            'Sky City pages about him are blank by design.'
        ],
        'glyph' => 'watcher-glyph.svg',
        'social' => [
            'handle' => '@MarosQuiet',
            'music' => 'Silence (on record)',
            'mood' => 'Unreadable',
            'location' => 'Watcher liaison decks',
            'signal' => 'Minimal posts · mostly reactions'
        ],
        'comments' => [
            ['author' => 'WatcherRecruit', 'text' => 'You ever smile? Asking anonymously.'],
            ['author' => 'TriumvirateBot', 'text' => 'Reminder: confidentiality clauses apply.'],
            ['author' => 'ShadowCart', 'text' => 'I know you keep the trophies polished.']
        ]
    ]
];

$character = $characters[$slug] ?? null;
$assets_base = trailingslashit( get_template_directory_uri() ) . 'assets/images/characters/';
$avatar_base = trailingslashit( $assets_base . 'avatars' );
?>
<div class="min-h-screen bg-abyss bg-tethys-radial text-slate-100">
    <div class="mx-auto max-w-5xl px-4 py-12 sm:px-6 lg:px-8">
        <?php if (!$character) : ?>
            <section class="rounded-3xl border border-slate-800/80 bg-slate-950/80 p-8 text-center">
                <p class="eyebrow text-lava-300">Character file unavailable</p>
                <h1 class="font-display text-4xl text-slate-50 mt-4">Redacted</h1>
                <p class="mt-2 text-sm text-slate-400">This profile hasn’t been decrypted yet. Return to the roster and pick another bond.</p>
                <a href="<?php echo esc_url( home_url( '/characters/' ) ); ?>" class="cta-primary mt-6 inline-flex">Back to characters</a>
            </section>
        <?php else : ?>
            <header class="hero-shell space-y-5">
                <div class="space-y-2">
                    <p class="eyebrow"><?php echo esc_html( $character['tagline'] ); ?></p>
                    <h1 class="font-display text-4xl font-semibold text-slate-50"><?php echo esc_html( $character['name'] ); ?></h1>
                    <p class="text-sm text-lava-200 uppercase tracking-[0.3em]"><?php echo esc_html( $character['status'] ); ?></p>
                </div>
                <blockquote class="rounded-3xl border border-slate-800/60 bg-slate-950/60 p-4 text-sm text-slate-300 italic">
                    <?php echo esc_html( $character['quote'] ); ?>
                </blockquote>
            </header>

            <section class="mt-10 grid gap-6 lg:grid-cols-[minmax(0,2fr)_minmax(0,1fr)]">
                <div class="rounded-3xl border border-slate-800/70 bg-slate-950/70 p-6 space-y-5">
                    <h2 class="text-2xl font-semibold text-slate-50">Field notes</h2>
                    <p class="text-sm text-slate-300"><?php echo esc_html( $character['summary'] ); ?></p>
                    <?php if (!empty($character['notables'])) : ?>
                        <ul class="list-disc space-y-2 pl-5 text-sm text-slate-300">
                            <?php foreach ($character['notables'] as $note) : ?>
                                <li><?php echo esc_html( $note ); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
                <div class="rounded-3xl border border-lava-400/20 bg-slate-950/70 p-6 space-y-4">
                    <h3 class="text-lg font-semibold text-slate-50">Vitals &amp; stats</h3>
                    <dl class="space-y-3 text-sm text-slate-300">
                        <?php foreach ($character['stats'] as $stat) : ?>
                            <div class="flex items-center justify-between gap-3">
                                <dt class="text-slate-400 uppercase tracking-[0.2em] text-[11px]"><?php echo esc_html( $stat['label'] ); ?></dt>
                                <dd class="text-right font-semibold text-slate-50"><?php echo esc_html( $stat['value'] ); ?></dd>
                            </div>
                        <?php endforeach; ?>
                    </dl>
                    <?php if (!empty($character['glyph'])) : ?>
                        <div class="pt-4 border-t border-slate-800/60">
                            <p class="text-[11px] uppercase tracking-[0.3em] text-slate-500 mb-2">Glyph</p>
                            <img src="<?php echo esc_url( $assets_base . $character['glyph'] ); ?>" alt="<?php echo esc_attr( $character['name'] . ' glyph' ); ?>" class="max-h-20 object-contain opacity-90" loading="lazy">
                        </div>
                    <?php endif; ?>
                </div>
            </section>

            <?php if ( ! empty( $character['social'] ) ) : ?>
                <?php
                    $social     = $character['social'];
                    $avatar_key = $social['avatar'] ?? ( $slug . '.jpg' );
                    $avatar_url = $avatar_base . $avatar_key;
                ?>
                <section class="mt-10 grid gap-6 lg:grid-cols-[minmax(0,1.2fr)_minmax(0,1fr)]">
                    <div class="rounded-3xl border border-slate-800/80 bg-slate-950/80 p-6 flex flex-col gap-5 md:flex-row md:items-center">
                        <div class="h-32 w-32 flex-shrink-0 overflow-hidden rounded-3xl border border-slate-700/70 bg-slate-900/60">
                            <img src="<?php echo esc_url( $avatar_url ); ?>" alt="<?php echo esc_attr( $character['name'] . ' avatar' ); ?>" class="h-full w-full object-cover" loading="lazy">
                        </div>
                        <div class="space-y-2">
                            <p class="text-[11px] uppercase tracking-[0.3em] text-slate-500">Profile signal</p>
                            <h3 class="text-2xl font-semibold text-slate-50"><?php echo esc_html( $social['handle'] ?? '@' . $character['name'] ); ?></h3>
                            <?php if ( ! empty( $social['mood'] ) ) : ?>
                                <p class="text-sm text-slate-300"><?php echo esc_html( $social['mood'] ); ?></p>
                            <?php endif; ?>
                            <?php if ( ! empty( $social['signal'] ) ) : ?>
                                <p class="text-xs uppercase tracking-[0.25em] text-lava-200"><?php echo esc_html( $social['signal'] ); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="rounded-3xl border border-slate-800/70 bg-slate-950/70 p-6 space-y-3">
                        <div class="flex items-center justify-between text-sm text-slate-400">
                            <span>Music</span>
                            <span class="text-right text-slate-100"><?php echo esc_html( $social['music'] ?? 'Unknown' ); ?></span>
                        </div>
                        <div class="flex items-center justify-between text-sm text-slate-400">
                            <span>Location</span>
                            <span class="text-right text-slate-100"><?php echo esc_html( $social['location'] ?? 'Undisclosed' ); ?></span>
                        </div>
                        <div class="flex items-center justify-between text-sm text-slate-400">
                            <span>Status</span>
                            <span class="text-right text-slate-100"><?php echo esc_html( $social['status'] ?? ( $social['mood'] ?? 'Active' ) ); ?></span>
                        </div>
                    </div>
                </section>
            <?php endif; ?>

            <?php if (!empty($character['secrets'])) : ?>
                <section class="mt-10 rounded-3xl border border-slate-800/80 bg-slate-950/80 p-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-2xl font-semibold text-slate-50">Redacted whispers</h3>
                        <span class="text-[11px] uppercase tracking-[0.3em] text-slate-500">Confidential</span>
                    </div>
                    <ul class="mt-4 grid gap-4 text-sm text-slate-300 md:grid-cols-3">
                        <?php foreach ($character['secrets'] as $secret) : ?>
                            <li class="rounded-2xl border border-slate-800/70 bg-slate-950/60 p-4">
                                <?php echo esc_html( $secret ); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </section>
            <?php endif; ?>

            <?php if ( ! empty( $character['comments'] ) ) : ?>
                <section class="mt-10 rounded-3xl border border-slate-800/70 bg-slate-950/70 p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-2xl font-semibold text-slate-50">Signal thread</h3>
                        <span class="text-[11px] uppercase tracking-[0.25em] text-slate-500">Fan chatter</span>
                    </div>
                    <ul class="space-y-4">
                        <?php foreach ( $character['comments'] as $comment ) : ?>
                            <li class="rounded-2xl border border-slate-800/60 bg-slate-950/60 p-4 shadow-soft-bronze">
                                <div class="flex items-center justify-between text-xs uppercase tracking-[0.25em] text-slate-500">
                                    <span><?php echo esc_html( $comment['author'] ?? 'Anonymous' ); ?></span>
                                    <span>↳ open channel</span>
                                </div>
                                <p class="mt-2 text-sm text-slate-200"><?php echo esc_html( $comment['text'] ?? '' ); ?></p>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </section>
            <?php endif; ?>

            <div class="mt-8 flex flex-wrap gap-4">
                <a href="<?php echo esc_url( home_url( '/characters/' ) ); ?>" class="cta-primary">Back to roster</a>
                <a href="<?php echo esc_url( home_url( '/reading-room/' ) ); ?>" class="nav-link--ghost text-slate-200">Reading Room intel</a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php get_footer(); ?>
