.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt



.. _configuration:

Configuration
-------------

This section describes the configuration options for the responsive picture tags inside pageTS. Everything is done within
TCEFORM.sys_file_reference


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

         media_width.addItems {
			(min-width: 200px): Very small device image
         }
