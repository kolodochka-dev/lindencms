<?php

namespace LindenCMS\Cms\Ui\Forms\Files;

use LindenCMS\Templator\Component;
use LindenCMS\Cms\Ui\Forms\Buttons\ButtonSecondary;
use LindenCMS\Cms\Ui\Forms\Icon;

class FileUpload extends Component
{
    public function __construct(
        public string $id = '',
        public ?string $label = '',
        public ?string $accept = '',
        // public mixed $error = null,
        public ?bool $multiple = true,
        public ?bool $hidden = false,
        // public string $icon = '',
        public ?string $route = '',
    ) {}

    protected function template(): string
    {
        $uploadButton = new ButtonSecondary(
            label: 'Upload',
            class: 'btn-sm',
            icon: 'material-symbols:upload-rounded',
            type: 'button',
            js: <<< JS
                onclick="event.preventDefault();this.closest('form').querySelector('.upload_file').click()"
            JS,
        );
        $messages = new Message($this->id);
        $uploadedList = new FileUploadedList(
            $this->id, 
            $this->getSlot('uploaded'), 
            'upload_uploadedList'
        );
        
        return <<< HTML
            <div class="upload {$this->if($this->hidden, 'hidden')}" id="{$this->id}">
                <div class="upload_header">
                    <div class="upload_header_title">
                        <h5>{$this->label}</h5>
                        {$this->if($this->accept, "<span>($this->accept)</span>")}
                    </div>
                    <div class="upload_header_actions">
                        <!-- <button class="upload_header_actions_clear">
                            {$this->pl(new Icon('mdi:delete-outline'))} Clear
                        </button> -->
                        <form hx-encoding="multipart/form-data"
                            hx-post="{$this->route}"
                            hx-swap="multi:#{$uploadedList->getId()}:{$this->if($this->multiple, 'beforeend', 'innerHTML')},#{$messages->getId()}:innerHTML"
                            hx-trigger="change"
                        >
                            $uploadButton
                            <input type="file" name="files[]" class="upload_file hidden" accept="{$this->accept}" {$this->if($this->multiple, 'multiple')} />
                            <input type="hidden" name="_token" value="{$this->pl(csrf_token())}">
                        </form>
                    </div>
                </div>
                {$this->pl($uploadedList)}
                {$this->pl($messages)}
            </div>
        HTML;
    }
}
