<?php

namespace LindenCMS\Cms\Ui\Uploader;

use LindenCMS\Cms\Images;
use LindenCMS\Cms\Image;
use LindenCMS\Cms\Ui\Buttons\Button;
use LindenCMS\Cms\Ui\EmptyState;
use LindenCMS\Cms\Ui\Icon;
use LindenCMS\Templator\Component;

class UploaderMulti extends Component
{
    public function __construct(
        public Images $images,
    ) {
    }

    protected function template(): string
    {
        $uploadButton = new Button(
            label: 'Upload',
            class: 'btn-sm bg-white border border-gray-300',
            icon: 'material-symbols:download-rounded',
            type: 'button',
            js: <<< JS
                onclick="event.preventDefault();this.closest('form').querySelector('.uploader_file').click()"
            JS,
        );

        return <<<HTML
            <div class="uploader" id="{$this->images->getUid()}">
                <div class="uploader_head">
                    <h5>{$this->pl($this->images->_view()?->label ?? 'Upload')}</h5>
                    <form {$this->pl($this->images->ctx()->htmx_upload())}</form>
                        $uploadButton
                        <input type="file" name="files[]" class="uploader_file hidden" accept="{$this->images->accept()}" multiple/>
                        <input type="hidden" name="_token" value="{$this->pl(csrf_token())}">
                    </form>
                </div>
                <div class="uploader_items">
                    {$this->loop($this->images->getItems(), fn (Image $image) => new UploaderItem($image, $this->images), new EmptyState)}
                </div>
            </div>
        HTML;
    }
}
