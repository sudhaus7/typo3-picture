.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt



.. _backendconfiguration:

Backend
-------------

New media queries can be added to the backend dropdown inside the variation through the PageTS tree by adding entries to:
TCEFORM.sys_file_reference.media_width


.. _media_width:

media_width
^^^^^^^^^^^

.. container:: table-row

   Property
         media_width

   Data type
         array

   Description
        List of media query widths

        Example:

        .. code-block:: typoscript

            media_width.addItems {
                (min-width: 200px): Very small device image
                (min-width: 1600px): Very large screen
            }
