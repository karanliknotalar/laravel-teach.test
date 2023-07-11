<x-admin.helpers.quill-text-area
    :quill-style="'height: 200px;'"
    :hidden-id="'quilltext'"
    :content="$site_setting->content ?? ''"
    :name="'content'"
    :title="'Değer (Value)'"/>
