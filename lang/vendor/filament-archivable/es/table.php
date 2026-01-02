<?php

return [

  'filters' => [

    'archived' => [

      'label' => 'Registros archivados',

      'only_archived' => 'Solo registros archivados',

      'with_archived' => 'Con registros archivados',

      'without_archived' => 'Sin registros archivados',

    ],
  ],

  'actions' => [

    'archive' => [

      'single' => [

        'label' => 'Archivar',

        'modal' => [

          'heading' => 'Archivar :label',

          'actions' => [

            'archive' => [

              'label' => 'Archivar',
            ],

          ],

        ],

        'notifications' => [

          'archived' => [

            'title' => 'Registro archivado',
          ],
        ],
      ],
    ],

    'unarchive' => [

      'single' => [

        'label' => 'Desarchivar',

        'modal' => [

          'heading' => 'Desarchivar :label',

          'actions' => [

            'unarchive' => [

              'label' => 'Desarchivar',
            ],

          ],
        ],

        'notifications' => [

          'unarchived' => [

            'title' => 'Registro desarchivado',
          ],
        ],
      ],
    ],
  ],
];
