<?php

namespace LindenCMS\Cms\Ui\Uploader;

use LindenCMS\Cms\Image;
use LindenCMS\Cms\Images;
use LindenCMS\Cms\Ui\Uploader\Traits\HasIcons;
use LindenCMS\Templator\Component;

class UploaderResponsiveItem extends Component
{
    use HasIcons;

    public function __construct(
        public Image $image,
        public Image|Images $root,
    ) {
    }

    protected function template(): string
    {
        $file = $this->image->file();
        $key = $this->image->getParentPropertyName();
        $uploaderItem = $this->image->getRoot(Image::class);
        $uploaderItemKey = $uploaderItem->getParentPropertyName();

        return <<<HTML
            <div class="uploader_responsive_item">
                <div class="uploader_responsive_item_body">
                    <img src="{$file->src()}" class="uploader_responsive_item_image">
                    <div class="uploader_responsive_item_content">
                        <div class="uploader_responsive_item_header">
                            <div class="uploader_responsive_item_title_row">
                                <h6>{$file->filename}</h6>
                                <div class="dropdown dropdown-end uploader_responsive_item_dropdown">
                                    <div tabindex="0" role="button" class="uploader_responsive_item_dropdown_btn">
                                        {$this->getIcon('options')}
                                    </div>
                                    <div tabindex="-1" class="dropdown-content uploader_responsive_item_dropdown_menu">
                                        <a href="{$file->downloadUrl()}" target="_blank" class="uploader_responsive_item_dropdown_item text-gray-700">
                                            Download {$this->getIcon('download')}
                                        </a>
                                        <a href="{$file->src()}" target="_blank" class="uploader_responsive_item_dropdown_item text-gray-700">
                                            Open {$this->getIcon('open')}
                                        </a>
                                        <button {$this->pl($this->root->ctx()->htmx_deleteResponsive($key, $uploaderItemKey))} class="uploader_responsive_item_dropdown_item text-error">
                                            Delete {$this->getIcon('delete')}
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="uploader_responsive_item_meta">
                                <div class="uploader_responsive_item_tags">
                                    {$this->loop($file->meta(), fn($item) => "<div class=\"uploader_responsive_item_tag\">$item</div>")}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="flex w-full gap-2 mt-2">
                        {$this->image->min_width->ctx()->html_form()}
                        {$this->image->max_width->ctx()->html_form()}
                    </div>
                    <div class="flex w-full gap-2 mt-2">
                        {$this->image->min_height->ctx()->html_form()}
                        {$this->image->max_height->ctx()->html_form()}
                    </div>
                </div>
               
                
                <input type="hidden" name="{$this->image->file->formName()}" value="{$file->id->get()}" />
                <input type="hidden" name="{$this->image->id->formName()}" value="{$this->image->id->get()}" />
            </div>
        HTML;
    }
}
