<?php

/*
|--------------------------------------------------------------------------
| MUST CSO — Website content & links
|--------------------------------------------------------------------------
| This is the one file you edit to change site-wide text, contact details,
| social links and Google Drive folders. After editing, re-run:
|
|     php artisan migrate:fresh --seed
|
| to refresh the database content (leaders, events, gallery, etc.).
|
| Anything marked SAMPLE must be replaced with your real information.
*/

return [

    // ---------------------------------------------------------------------
    // Organization
    // ---------------------------------------------------------------------
    'org' => [
        'name' => 'MUST Catholic Students Organization',
        'short' => 'MUST CSO',
        'university' => 'Malawi University of Science and Technology',
        'university_short' => 'MUST',
        'campus' => 'Ndata Campus, Thyolo, Malawi',
        'tagline' => 'One Faith. One Family.',
        // SAMPLE — confirm the official motto with the executive committee.
        'motto' => 'Faith in Action, Service with Love',
        'mission' => 'To unite Catholic students of the Malawi University of Science and Technology in worship, fellowship and service — nurturing mature Christians who live out the Gospel on campus and beyond.',
        'vision' => 'A vibrant Catholic student community that is the light of faith, hope and charity at MUST and in the wider Malawian society.',
        // SAMPLE — replace with the real founding year.
        'founded' => 2015,
        'logo' => '/images/cso-logo.png',
        // SAMPLE — replace with the link to a short Holy Mass highlight clip.
        // Keep this null until you have a hosted video; the hero highlight then stays hidden.
        'hero_video' => null,
        // Exact TikTok video post URL (must end in /video/...) for the featured player on Activities.
        'featured_tiktok_url' => null,
    ],

    // ---------------------------------------------------------------------
    // Media fallbacks
    // ---------------------------------------------------------------------
    // Used when an activity, event or article has no uploaded photograph yet,
    // so media-first cards never render as empty grey blocks.
    'media_fallbacks' => [
        '/images/gallery/12usmszhcdLinTYwV3RjQD3rObfSgeLQL.jpg',
        '/images/gallery/1I83BoNPnpOozJx7-iXThQOkPn8sr4xuV.jpg',
        '/images/gallery/1WS1K0jiEOHhCE-uwy2xagCFEUzHwRVn3.jpg',
        '/images/gallery/1Pt2sQzEhFcWA6VP962TRptoVSN5J-qBP.jpg',
        '/images/gallery/1HwaaaeG7vkZBJTMW4tLkPRgazSqq5A3g.jpg',
        '/images/gallery/1bdmVvE8P672fSMjPOwR9Uq08nZpL2B2b.jpg',
        '/images/gallery/10YvZrv8fIpp3UXPudDo4tuAo_B9z6_OZ.jpg',
        '/images/gallery/1cZpO3y2_w0rt0QekenHkzvMzf4K5XFu6.jpg',
        '/images/gallery/1oedIYxnEIYKQZX_SaZS19RYmnrty67V4.jpg',
        '/images/gallery/17rtTWn0HMsfeOBuUTX0v2HmNkNdm3CwH.jpg',
    ],

    // ---------------------------------------------------------------------
    // Contact & location
    // ---------------------------------------------------------------------
    'contact' => [
        // SAMPLE — replace with the official CSO mailbox.
        'email' => 'cso@must.ac.mw',
        'phone' => '+265 000 000 000', // SAMPLE
        'location' => 'MUST Ndata Campus, Thyolo, Malawi',
        'meeting_venue' => 'MUST Main Lecture Hall / Campus Chapel',
        'meeting_time' => 'Every Friday, 6:00 PM',
        'postal' => 'P.O. Box 519, Thyolo, Malawi',
    ],

    // ---------------------------------------------------------------------
    // Social platforms — centralized links for the footer icons.
    // Set url to null until the official link is ready (icons stay visible but non-navigating).
    // ---------------------------------------------------------------------
    'socials' => [
        ['key' => 'facebook', 'label' => 'Facebook', 'url' => null],
        ['key' => 'x', 'label' => 'X (Twitter)', 'url' => null],
        ['key' => 'instagram', 'label' => 'Instagram', 'url' => null],
        ['key' => 'tiktok', 'label' => 'TikTok', 'url' => 'https://www.tiktok.com/@must.cso'],
    ],

    // ---------------------------------------------------------------------
    // Google Drive folders
    //
    // Paste each shared folder link into `url` (Share > Anyone with the
    // link > Copy link). Leave `url` as null and the card shows as
    // "Link coming soon" instead of a broken button.
    //
    // `photos` entries also feed the gallery: paste Drive file IDs into
    // `files` (the long ID in .../file/d/<ID>/view) or leave the seeded
    // ones from your three current albums.
    // ---------------------------------------------------------------------
    'drive' => [
        'main' => 'https://drive.google.com/drive/folders/1jluYdy9KPDybCkjWyaknATGMnS5qFR7J',

        'folders' => [
            [
                'key' => 'gallery',
                'title' => 'Gallery Photos',
                'description' => 'Full-resolution photos from Holy Mass, devotions, meetings and outreach.',
                'url' => 'https://drive.google.com/drive/folders/1jluYdy9KPDybCkjWyaknATGMnS5qFR7J',
                'icon' => 'images',
                'photos' => 364,
            ],
            [
                'key' => 'videos',
                'title' => 'Event Videos',
                'description' => 'Choir performances, retreat recordings and event highlights.',
                // TODO: paste your videos folder link here.
                'url' => null,
                'icon' => 'video',
                'photos' => null,
            ],
            [
                'key' => 'documents',
                'title' => 'Reports & Documents',
                'description' => 'Activity reports, constitutions, budgets and official CSO documents.',
                // TODO: paste your documents folder link here.
                'url' => null,
                'icon' => 'file-text',
                'photos' => null,
            ],
        ],

        // Albums shown in the gallery. `files` are Google Drive file IDs:
        // open a photo in Drive and copy the ID from .../file/d/<ID>/view.
        // You can add as many IDs as you like — the full album lives in Drive.
        'albums' => [
            [
                'name' => 'SUN181026',
                'label' => 'Sunday Mass — 18 October 2026',
                'category' => 'Holy Mass',
                'folder_id' => '1phAOlkqLbPoMqkt0xaXiQJ8KEottV8GG',
                'total' => 205,
                'files' => [
                    '12usmszhcdLinTYwV3RjQD3rObfSgeLQL', '1I83BoNPnpOozJx7-iXThQOkPn8sr4xuV',
                    '1WS1K0jiEOHhCE-uwy2xagCFEUzHwRVn3', '1Pt2sQzEhFcWA6VP962TRptoVSN5J-qBP',
                    '1HwaaaeG7vkZBJTMW4tLkPRgazSqq5A3g', '1bdmVvE8P672fSMjPOwR9Uq08nZpL2B2b',
                    '1RjUpvUvpkRS4sRNd5caVv0jtbZK3ykMf', '1QcXlEf0ocLDrkDqpEOaywueqCkjb2qp4',
                    '141s22hCw6_P069wuKw5gBl3t1FrgZCub', '1VSI8Jwb3NTPqZz2Tm9DN-uyySdAdG1n6',
                    '184Ma38wispWoO70dWh1b6Y0tqEEQbdM9', '1nQBNUa8f5ZZasACiWddPp8eWKlC_e4RB',
                    '1olYCzka-Ku5qNHeE9I9zeE1MIOf2TAx-', '1zn-hxxX-cjS9NWl2DGq0k2cbq0LrcUuS',
                    '1rBk8IZ4ulUm5InS8bCdbEpKa2mMmpx3Y', '1k8aGaxFpEos25SoIy1-qMCdLGCRcqJNa',
                    '1SZnaezxwFMqrjDtHFwt6vpEBdes0VYET', '1wPp3UZAi930_bTeqSbaJgcrezNhlAyBD',
                ],
            ],
            [
                'name' => 'THU102226',
                'label' => 'CSO Gathering — 22 October 2026',
                'category' => 'CSO Meetings & Fellowship',
                'folder_id' => '1jluYdy9KPDybCkjWyaknATGMnS5qFR7J',
                'total' => 146,
                'files' => [
                    '10YvZrv8fIpp3UXPudDo4tuAo_B9z6_OZ', '1cZpO3y2_w0rt0QekenHkzvMzf4K5XFu6',
                    '1oedIYxnEIYKQZX_SaZS19RYmnrty67V4', '1PrOw3TbO_msEcZX7nEwq5hESWm2ohp7n',
                    '1uk98FIgaYIusBOCr9qGfhKRXmfgDkX7n', '1AQnCkSpWjKVa_sSN2RW_sF625p2Di2B_',
                    '1rDm_iP17PmBpbyypEPEM_PnLh9EvJ5ek', '1FdTqJgGwXmLgi6gjH8oeqcUSCb-AkA7A',
                    '1lWPDRgmyE-2KFHmsbcwIBKuXIcT6ACOX', '1S_vT0ZD0MOOv2EkJJcHt6XT111poa2pu',
                    '13ARXsk4YZ57neLGHEKsZ4lU03-reuBbz', '1OKngBHqfpX6ViNaLUHWJCRinZyaqW-7S',
                    '1ZbYBz7pCJpiPQrZa_HtmPl-DrdpT-rjQ', '1EuUpqZmd-PUNIxPV3cd6rlLKJvRZzJuv',
                    '1uuQ-1vaXOi6v1_0RoXUGedkIqY2POrbr',
                ],
            ],
            [
                'name' => 'M’PHAKATI 2-311026',
                'label' => 'M’Phakati Fellowship — 31 October 2026',
                'category' => 'CSO Meetings & Fellowship',
                'folder_id' => '1RQ5vw-luivmfep2m0wKpS3H3nXPce5lj',
                'total' => 13,
                'files' => [
                    '10kA2YHDWECR9gAVRSc6ZL5m8xYeVT7mC', '1GdyW-HK_p4pSCRPZwl8T_4_G-gI5g4Sn',
                    '1tG3WOjzqkx-SyHxUo1hJVlLwYPXODP70', '15CFwoH-mJ_Y-Y8-sgcDJepe2XO2LBJk9',
                    '1wbmyZDNlPZPBCzHVEQylvon79C7-g4Ib', '1WbtWAxzmik3vZFU0SYIOzzDc4GDCR9Ks',
                    '1Xa-apnzeuKCLijlBuAGTYn1e_PESe9Ky', '1C-ceBNwYWgNg8S--wDqB2u_HPdCpObPP',
                    '1rCXF8XnzlDceYKQZX_Asra6I4zlyaNL7', '1bDNtvQX5n-bYq6HtbfHPQJovK0eXNW2j',
                    '1F7Dw1rIsWVYdvdldDkCO3cxPvtqequdp', '1Xq3YtOEaPLgYUluO1LeQW9VeGWSAw_D_',
                    '17rtTWn0HMsfeOBuUTX0v2HmNkNdm3CwH',
                ],
            ],
        ],
    ],

    // ---------------------------------------------------------------------
    // Academic structure (used by the membership form)
    // Source: the four MUST schools and their published programmes.
    // ---------------------------------------------------------------------
    'academic' => [
        'years' => ['1' => 'Year 1', '2' => 'Year 2', '3' => 'Year 3', '4' => 'Year 4', '5' => 'Year 5', '6' => 'Year 6'],
        'schools' => [
            'mit' => [
                'label' => 'Malawi Institute of Technology (MIT)',
                'departments' => ['Applied Studies', 'Computer Studies & Information Technology', 'Engineering'],
                'programmes' => [
                    'BEng (Hons) Biomedical Engineering',
                    'BEng (Hons) Chemical Engineering',
                    'BEng (Hons) Manufacturing Engineering',
                    'BEng (Hons) Metallurgy and Materials Engineering',
                    'BEng (Hons) Polymer and Textile Engineering',
                    'BSc Computer Systems and Security',
                    'BSc Business Information Technology',
                    'BSc Sciences Education',
                    'BSc Food Science and Technology',
                    'BSc Mathematical Sciences',
                ],
            ],
            'ams' => [
                'label' => 'Academy of Medical Sciences (AMS)',
                'departments' => ['Clinical Sciences', 'Biological Sciences'],
                'programmes' => [
                    'BSc Medical Microbiology',
                    'BSc Immunology',
                    'BSc Medical Imaging (Diagnostic Radiography)',
                    'BSc Medical Imaging (Diagnostic Ultrasound)',
                    'BSc Sport Science',
                ],
            ],
            'nsces' => [
                'label' => 'Ndata School of Climate and Earth Sciences (NSCES)',
                'departments' => ['Climate Sciences', 'Water Resources Management', 'Energy Resources', 'Earth Sciences'],
                'programmes' => [
                    'BEng (Hons) Sustainable Energy Engineering',
                    'BSc Meteorology and Climate Science',
                    'BSc Earth Science (Geology)',
                    'BSc Disaster Risk Management',
                    'BSc Geo-Sciences (Earth Observation)',
                    'BSc Petroleum Geo-Science (Oil and Gas)',
                    'BSc Water Quality Management',
                ],
            ],
            'bisch' => [
                'label' => 'Bingu School of Culture and Heritage (BISCH)',
                'departments' => ['Indigenous Knowledge Systems and Practices', 'Language and Communication', 'African Musicology'],
                'programmes' => [
                    'BA African Musicology',
                    'BA Indigenous Knowledge Systems and Practice',
                    'BA Language, Communication and Culture',
                    'BA Cultural Economy',
                    'BA Language Education',
                    'BA Archiving and Records Management',
                ],
            ],
        ],
    ],

    // ---------------------------------------------------------------------
    // Patron saint spotlight
    // SAMPLE — replace with the real patron saint of MUST CSO.
    // ---------------------------------------------------------------------
    'patron_saint' => [
        'name' => 'St. Thomas Aquinas',
        'title' => 'Patron of Students and Christian Youth',
        'feast_day' => '28 January',
        'image' => null,
        'bio' => 'Born in 1225, Thomas Aquinas studied at the University of Naples and taught at the University of Paris and Rome, becoming the Church\'s greatest theologian. He is remembered for his deep study, his teaching of the faith and his love for God and neighbour.',
        'inspiration' => 'Thomas shows us that faith is learned through study, prayer and practice, and that holiness is available to every student who seeks God with all their heart.',
        'quote' => 'God is the source of all goodness, and to love Him is to love Him alone and our neighbour as ourselves.',
    ],

    // ---------------------------------------------------------------------
    // Objectives & core values (bento grid on the About page)
    // ---------------------------------------------------------------------
    'values' => [
        [
            'title' => 'Faith',
            'icon' => 'cross',
            'description' => 'To deepen the spiritual life of every member through the sacraments, prayer and sound Catholic teaching.',
        ],
        [
            'title' => 'Service',
            'icon' => 'heart-handshake',
            'description' => 'To serve the poor, the sick and the needy on campus and in our surrounding communities.',
        ],
        [
            'title' => 'Unity',
            'icon' => 'users',
            'description' => 'To build one family of Catholic students across every faculty, year and background at MUST.',
        ],
        [
            'title' => 'Academic Excellence',
            'icon' => 'graduation-cap',
            'description' => 'To encourage members to excel in their studies as an act of worship and stewardship of their talents.',
        ],
        [
            'title' => 'Integrity',
            'icon' => 'shield-check',
            'description' => 'To form men and women of honest character and moral courage, in public and in private.',
        ],
        [
            'title' => 'Evangelisation',
            'icon' => 'flame',
            'description' => 'To share the joy of the Gospel with fellow students through friendship, witness and outreach.',
        ],
    ],

    // ---------------------------------------------------------------------
    // "CSO at a Glance" statistics (home page)
    // ---------------------------------------------------------------------
    'glance' => [
        ['icon' => 'users', 'value' => '12', 'label' => 'MPHAKATIS'],
        ['icon' => 'heart-handshake', 'value' => '4', 'label' => 'AFFILIATIONS'],
        ['icon' => 'graduation-cap', 'value' => '350+', 'label' => 'STUDENTS'],
        ['icon' => 'calendar-days', 'value' => '10', 'label' => 'YEARS ON CAMPUS'],
    ],

    // ---------------------------------------------------------------------
    // Hero statistics
    // ---------------------------------------------------------------------
    'stats' => [
        ['label' => 'Active members', 'value' => '350+'],
        ['label' => 'Weekly gatherings', 'value' => '6'],
        ['label' => 'Years on campus', 'value' => '10'],
        ['label' => 'Outreach visits a year', 'value' => '12'],
    ],

    // ---------------------------------------------------------------------
    // Marquee pillars (home page ticker)
    // ---------------------------------------------------------------------
    'pillars' => [
        'Holy Mass',
        'Morning Devotion',
        'Friday CSO Meetings',
        'Choir & Liturgy',
        'Charity & Outreach',
        'Bible Study',
        'Youth Fellowship',
    ],
];
