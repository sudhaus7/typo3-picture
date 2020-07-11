.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt

.. _drop in partial:

Drop-in ready partial
---------------------

There is a drop-in preconfigured implementation of all of this available in this extension if you use fluid_styled_content. It is enabled by default, but depending of you implementation it might not be used.


.. _drop-in Typoscript configuration

Typoscript configuration
^^^^^^^^^^^^^^^^^^^^^^^^

.. code-block:: typoscript

    lib.contentElement {
        partialRootPaths {
            1 = EXT:responsive_picture/Resources/Private/Partials/
        }
    }

This enables for fluid_styled_content to load the extensions own partial, which is `Media/Rendering/Image.html`

.. _drop-in Partial for rendering

Partial
^^^^^^^

.. code-block:: html

    <picture>
        <f:for each="{file.variants}" as="variant">
            <source media="{variant.mediaquery}"
                    srcset="{f:uri.image(image: '{variant}', maxWidth: '{variant.variationmaxwidth}', maxHeight: '{variant.variationmaxheight}')}">
        </f:for>
        <f:media alt="{file.alternative}"
                 class="image-embed-item"
                 file="{file}"
                 height="{dimensions.height}"
                 loading="{settings.media.lazyLoading}"
                 style="width:auto;height:auto;max-width:100%"
                 title="{file.title}"
                 width="{dimensions.width}" />
    </picture>

This will create a <picture> element with several <source> elements according to the configured media sizes, resized according to the max width and height and the original image as fallback. Cropping informations are applied as well in this step.
