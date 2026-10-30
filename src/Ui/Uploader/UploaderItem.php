<?php

namespace LindenCMS\Cms\Ui\Uploader;

use LindenCMS\Cms\Image;
use LindenCMS\Cms\Images;
use LindenCMS\Cms\Ui\EmptyState;
use LindenCMS\Cms\Ui\Uploader\Traits\HasIcons;
use LindenCMS\Templator\Component;

class UploaderItem extends Component
{
    use HasIcons;

    public function __construct(
        public Image $image,
        public Image|Images $root,
    ) {
    }

    protected function template(): string
    {
        $responsiveImages = $this->image->responsiveVersions->getItems();
        $file = $this->image->file();
        $key = $this->image->getParentPropertyName();

        return <<<HTML
            <div class="uploader_item">
                <div class="uploader_item_body">
                    <img src="{$file->src()}" class="uploader_item_image">
                    <div class="uploader_item_content">
                        <div class="uploader_item_header">
                            <div class="uploader_item_title_row">
                                <h6>{$file->filename}</h6>
                                <div class="dropdown dropdown-end uploader_item_dropdown">
                                    <div tabindex="0" role="button" class="uploader_item_dropdown_btn">
                                        {$this->getIcon('options')}
                                    </div>
                                    <div tabindex="-1" class="dropdown-content uploader_item_dropdown_menu">
                                        <a href="{$file->downloadUrl()}" target="_blank" class="uploader_item_dropdown_item text-gray-700">
                                            Download {$this->getIcon('download')}
                                        </a>
                                        <a href="{$file->src()}" target="_blank" class="uploader_item_dropdown_item text-gray-700">
                                            Open {$this->getIcon('open')}
                                        </a>
                                        <form {$this->pl($this->root->ctx()->htmx_uploadResponsive($key))}</form>
                                            <button class="uploader_item_dropdown_item text-gray-700" onclick="event.preventDefault();this.closest('form').querySelector('.uploader_file').click()">
                                                Responsive {$this->getIcon('responsive')}
                                            </button>
                                            <input type="file" name="files[]" class="uploader_file hidden" accept="{$this->root->accept()}"/>
                                            <input type="hidden" name="_token" value="{$this->pl(csrf_token())}">
                                        </form>
                                        <button {$this->pl($this->root->ctx()->htmx_delete($key))} class="uploader_item_dropdown_item text-error">
                                            Delete {$this->getIcon('delete')}
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="uploader_item_meta">
                                <div class="uploader_item_tags">
                                    {$this->loop($file->meta(), fn ($item) => "<div class=\"uploader_item_tag\">$item</div>")}
                                </div>
                            </div>
                        </div>
                        <div class="uploader_item_footer">
                            <div class="dropdown uploader_item_edit_dropdown">
                                <div tabindex="0" role="button" class="uploader_item_edit_btn">
                                    {$this->getIcon('edit')} Edit
                                </div>
                                <div tabindex="-1" class="dropdown-content uploader_item_edit_menu">
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="{$this->image->file->formName()}" value="{$file->id->get()}" />
                    <input type="hidden" name="{$this->image->id->formName()}" value="{$this->image->id->get()}" />
                </div>

                <details class="uploader_responsive">
                    <summary class="uploader_responsive_summary">
                        <span class="uploader_responsive_title">
                            Responsive versions
                        </span>
                        <span class="uploader_responsive_icon">
                            {$this->getIcon('collapse')}
                        </span>
                    </summary>
                    <div class="uploader_responsive_content">
                        {$this->loop($responsiveImages, fn(Image $item) => new UploaderResponsiveItem($item, $this->root), new EmptyState)}
                    </div>
                </details>
            </div>
        HTML;
    }
}
