.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt



.. _Frontend Configuration:

Frontend
--------

Image sizes and media queries are managed in TypoScript in `config.tx_responsivepicture`

.. code-block:: typoscript

    config.tx_responsivepicture {
        autocreatevariations = 1
        sizes {
            10 {
                key = (min-width: 1200px)
                mediaquery = (min-width: 1200px)
                maxW = 1600
                maxH = 1600
            }
            20 {
                key = (min-width: 768px)
                mediaquery = (min-width: 768px)
                maxW = 1024
                maxH = 1024
            }
            30 {
                key = (min-width: 300px)
                mediaquery = (min-width: 300px)
                maxW = 600
                maxH = 600
            }
        }
    }


.. _autocreatevariations:

config.tx_responsivepicture.autocreatevariations
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

.. container:: table-row

   Property
         autocreatevariations

   Data type
         bool

   Description
         Defines if missing media variations should automatically be created. Default: true



.. _sizes:

config.tx_responsivepicture.sizes
^^^^^^^^^^^

.. container:: table-row

   Property
         sizes

   Data type
         array

   Description
         List of media queries and the respective sizes. The order of this list is preserved and reflects the order of the variations in the file reference.

.. _sizeskey:

config.tx_responsivepicture.sizes.[idx].key
^^^^^^^^^^^

.. container:: table-row

   Property
         key

   Data type
         string

   Description
         The identifier / key of this setting. This must correspond with the key in the PageTS configuration of `TCEFORM.sys_file_reference.media_width`. For backwards compatibility this looks like the media query, but can be any character sequence.


.. _sizesmediaquery:

config.tx_responsivepicture.sizes.[idx].mediaquery
^^^^^^^^^^^

.. container:: table-row

   Property
         mediaquery

   Data type
         string

   Description
         The concrete media query used later in the `<source>` tag inside a `<picture>` element


.. _sizesmaxw:

config.tx_responsivepicture.sizes.[idx].maxW
^^^^^^^^^^^

.. container:: table-row

   Property
         maxW

   Data type
         string

   Description
         The max width of the image variation to be generated for this media query.


.. _sizesmaxh:

config.tx_responsivepicture.sizes.[idx].maxH
^^^^^^^^^^^

.. container:: table-row

   Property
         maxH

   Data type
         string

   Description
         The max height of the image variation to be generated for this media query.




