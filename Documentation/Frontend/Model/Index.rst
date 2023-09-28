.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt

.. _frontendmodel:

Model and Properties
--------------------

the following properties are now additionally available to a file_reference (\\TYPO3\\CMS\\Core\\Resource\\FileReference) object in the Frontend.


New properties
^^^^^^^^^^^^^^

.. _model_variants:

.. container:: table-row

    Property
        variants

    Method
        FileReference::getVariants()

    Data type
        array

    Description
        retrives an array of file references containing the media variations (see :ref:`Frontend Configuration`). The data is loaded when the property is accessed the first time.

        Example:

        .. code-block:: html

            <f:for each="{image.variants}" as="variant">
                do stuff
            </f:for>

.. _model_isvariant:

.. container:: table-row

    Property
        variant

    Method
        FileReference::isVariant()

    Data type
        bool

    Description
        returns true if a file reference is a variant of another file reference

        Example:

        .. code-block:: html

            <f:for each="{image.variants}" as="variant">
                <f:if condition="{variant.variant}">
                    do something conditionally
                </f:if>
            </f:for>


.. _model_mediaquery:

.. container:: table-row

    Property
        mediaquery

    Method
        FileReference::getMediaquery()

    Data type
        string

    Description
        returns the media query for this variant. If the object is not a variation then it will return an empty string.

        Example:

        .. code-block:: html

            <f:for each="{image.variants}" as="variant">
                <source media="{variant.mediaquery}" .. />
            </f:for>

.. _model_mediawidth:

.. container:: table-row

    Property
        variationmaxwidth

    Method
        FileReference::getVariationmaxwidth()

    Data type
        string

    Description
        returns the configured max width for this variation.

        Example:

        .. code-block:: html

            <f:for each="{image.variants}" as="variant">
                <source srcset="{f:uri.image(image: '{variant}', maxWidth: '{variant.variationmaxwidth}')}">
            </f:for>

.. _model_mediaheight:

.. container:: table-row

    Property
        variationmaxheight

    Method
        FileReference::getVariationmaxheight()

    Data type
        string

    Description
        returns the configured max height for this variation.

        Example:

        .. code-block:: html

            <f:for each="{image.variants}" as="variant">
                <source srcset="{f:uri.image(image: '{variant}', maxHeight: '{variant.variationmaxheight}')}">
            </f:for>
