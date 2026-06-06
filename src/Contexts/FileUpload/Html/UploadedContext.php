<?php

namespace LindenCMS\Cms\Contexts\FileUpload\Html;

use LindenCMS\Cms\Contexts\HtmlContext;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\File;
use LindenCMS\Cms\Nodes\FileUpload;
use LindenCMS\Cms\Nodes\FileUploads;
use LindenCMS\Cms\Ui\Forms\Files\Message;
use LindenCMS\Cms\Ui\Forms\Files\FileUploadedList;
use LindenCMS\Cms\Ui\Forms\Icon;

class UploadedContext extends HtmlContext
{
    /** @var FileUpload */
    protected Node $node;

    public function __invoke(): mixed
    {
        /** @var File */
        if (!$file = $this->getData('file')) {
            return '';
        }
        $isMain = $this->getData('isMain', true);
        $id = "uploaded-{$this->node->getUid()}";
        $root = $this->node->getRoot(FileUploads::class);
        
        // Message is relate to the Main uploader
        $messages = new Message($root->getUid());
        $uploadedList = new FileUploadedList(
            $this->node->getUid(), 
            $this->responsiveVersions($this->getData('responsiveVersions', [])), 
            'upload_uploadedList_item_responsiveList'
        );
        
        return <<< HTML
            <div id="$id" class="upload_uploadedList_item {$this->if($isMain, ' shadow border-border-100 hover:border-primary-300', 'border-border')}">
                <div class="upload_uploadedList_item_content">
                    <img src="{$file->previewUrl()}"/>
                    <div class="upload_uploadedList_item_content_info">
                        <div class="upload_uploadedList_item_content_info_up">
                            <h6>{$file->filename->get()}</h6>
                            <span>{$file->uploaded_at->get()}</span>
                        </div>
                        <div class="upload_uploadedList_item_content_info_middle">
                            <span>{$file->extension->get()}</span>
                            <span>{$file->getMb(1)}</span>
                        </div>
                        <div class="upload_uploadedList_item_content_info_down">
                            <div class="upload_uploadedList_item_content_info_down_actions">
                                {$this->editForm()}
                                <a class="--info" href="{$file->downloadUrl()}" target="_blank">
                                    {$this->pl(new Icon('material-symbols:download-rounded'))} Download
                                </a>
                                <a class="--accent" href="{$file->url()}" target="_blank">
                                    {$this->pl(new Icon('majesticons:open-line'))} Open
                                </a>
                                <button class="--error" onclick="document.querySelector('#$id').remove()">
                                    {$this->pl(new Icon('mdi:delete-outline'))} Delete
                                </button>
                            </div>
                            <div>
                                {$this->if($isMain, $this->addResponsive($root, $messages, $uploadedList), $this->selectResponsive())}
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="{$this->node->file_id->formName()}" value="{$file->id->get()}" />
                    {$this->node->parent_id->context('html.form')}
                </div>

                {$this->if($isMain, "
                    <div class=\"upload_uploadedList_item_responsiveList_wrapper\">
                        <h5>Responsive Versions</h5>
                        $uploadedList
                    </div>
                ")}

                {$this->node->id->context('html.form', ['hidden' => true])}
                {$this->node->parent_uid->context('html.form', ['value' => $this->getData('parent_uid')])}
            </div>
        HTML;
    }

    private function editForm(): string
    {
        $popover = "popover_{$this->node->getUid()}";
        $anchor = "anchor_{$this->node->getUid()}";

        return <<< HTML
            <!-- <div class="dropdown">
                <button tabindex="0" role="button" class="dropdown-trigger flex items-center gap-1 rounded hover:text-secondary text-secondary-300 cursor-pointer">
                    {$this->pl(new Icon('mdi:square-edit-outline'))} Edit
                </button>
                <div tabindex="0" class="dropdown-content tile w-96">
                    {$this->loop($this->node->fillableNodes(), fn($item) =>$item->context('html.form'))}
                </div>
            </div> -->

            <!-- change popover-1 and --anchor-1 names. Use unique names for each dropdown -->
            <div>
                <button class="flex items-center gap-1 rounded hover:text-secondary text-secondary-300" 
                    popovertarget="{$popover}" style="anchor-name:--{$anchor}">
                    {$this->pl(new Icon('mdi:square-edit-outline'))} Edit
                </button>
                <div class="dropdown tile w-96" popover id="{$popover}" style="position-anchor:--{$anchor}">
                    {$this->loop($this->node->fillableNodes(), fn($item) =>$item->context('html.form'))}
                </div>
            </div>
        HTML;
    }

    private function addResponsive(FileUploads $root, Message $messages, FileUploadedList $uploadedList): string
    {
        $route = route('htmx', [
            'method' => 'upload',
            'code' => $this->node->getRoot()->code(),
            'path' => $root->getPath(),
            'messagesId' => $root->getUid(),
            'uploadedListId' => $this->node->getUid(),
            'data' => [
                'isMain' => false,
                'parent_uid' => $this->node->getUid(),
                'accept' => $this->getData('accept', ''),
            ],
        ]);

        return <<< HTML
            <form hx-encoding="multipart/form-data"
                hx-post="{$route}"
                hx-trigger="change"
                hx-swap="multi:#{$uploadedList->getId()}:beforeend,#{$messages->getId()}:innerHTML"
            >
                <button class="btn btn-sm btn-secondary btn-outline" onclick="event.preventDefault();this.closest('form').querySelector('.upload_file').click()">
                    {$this->pl(new Icon('material-symbols:upload-rounded'))} Responsive
                </button>
                <input type="file" name="files[]" class="upload_file hidden" accept="{$this->getData('accept', '')}" multiple />
                <input type="hidden" name="_token" value="{$this->pl(csrf_token())}">
            </form>
        HTML;
    }

    private function selectResponsive(): string
    {
        return $this->node->width->context('html.form', ['inline' => true]);
    }

    private function responsiveVersions(array $items): string
    {
        return $this->loop($items, fn($item) => $item->context('html.uploaded', [
            'file' => $item->file(),
            'isMain' => false,
            'parent_uid' => $this->node->getUid(),
            'accept' => $this->getData('accept', ''),
        ]));
    }
}
