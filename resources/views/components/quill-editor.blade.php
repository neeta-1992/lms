@props(['name','required','id','value','files'])
<div class="quillEditor">
    <div id="{{ $id ?? '' }}-toolbar-container" class="ql-toolbar ql-snow">
        <span class="ql-formats">
		  <select class="ql-font"></select>
		  <select class="ql-size"></select>
		</span>
		<span class="ql-formats">
		  <button class="ql-bold"></button>
		  <button class="ql-italic"></button>
		  <button class="ql-underline"></button>
		  <button class="ql-strike"></button>
		</span>
		<span class="ql-formats">
		  <button class="ql-header" value="1"></button>
		  <button class="ql-header" value="2"></button>
		</span>
		<span class="ql-formats">
		  <button class="ql-list" value="ordered"></button>
		  <button class="ql-list" value="bullet"></button>
		  <button class="ql-indent" value="-1"></button>
		  <button class="ql-indent" value="+1"></button>
		</span>
		<span class="ql-formats">
		  <button class="ql-direction" value="rtl"></button>
		  <select class="ql-align"></select>
		</span>
		{{-- <span class="ql-formats">
			<button class="ql-link"></button>
			<button class="ql-image"></button>
		</span> --}}
		<span class="ql-formats">
			<label class="message_images" for="message_images">
				<i class="fa-thin fa-paperclip"></i>
				<input type="file" class="fileUpload d-block" name="image[]" multiple id="message_images"  data-file="message" accept=".png,.jpg,.jpeg,.svg,gif,.pdf" />
			</label>
		</span>
    </div>
    <div id="{{ $id ?? '' }}-editor" class="qEditor"  {!! $attributes->merge(['class' => '']) !!} >{!! $value ?? '' !!}</div>
    <input type="text" style="opacity: 0; position: absolute; pointer-events: none;" name="{{ $name ?? '' }}" class="quillEditorInput" {{ isset($required) ? 'required' : '' }}  value="{!! $value ?? '' !!}"/>
</div>
<div class="image_list_box">
     @if(!empty($files))
             @foreach($files as $key => $file)
                <div class="flow-progress media">
                        <div class="media-body">
                            <div><strong class="flow-file-name">{{ $file->original_name }}</strong> <br> <em
                class="flow-file-progress text-success">(file successfylly uploaded: )</em></div>

                            </div>
                        <div class="ml-3 align-self-center"><button type="button"
                                class="flow-file-cancel btn btn-sm removeUploedFile"
                                data-file-name="{{ $file->file_name }}" data-id="" data-type="mail" data-html="true"><i class="fal fa-times-circle"></i></button>
                                </div>
                    </div>
             @endforeach
        @endif
</div>
