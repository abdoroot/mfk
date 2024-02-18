
<?php
    $auth_user= authSession();
?>
{{ Form::open(['route' => ['my-home.destroy', $data->id], 'method' => 'delete','data--submit'=>'myhome'.$data->id]) }}
<div class="d-flex justify-content-end align-items-center">
    @if(!$data->trashed())
        @if($auth_user->can('category delete'))
        <a class="mr-3 delete-category" href="{{ route('my-home.destroy', $data->id) }}" data--submit="myhome{{$data->id}}" 
            data--ajax="true"
            data--datatable="reload"
            data--confirmation="true"
            data-title="{{ __('myhome',['form'=>  __('myhome') ]) }}"
            title="{{ __('messages.delete_form_title',['form'=>  __('messages.myhome') ]) }}"
            data--message='{{ __("messages.delete_msg") }}'>
            <i class="far fa-trash-alt text-danger"></i>
        </a>
        @endif
    @endif
    @if(auth()->user()->hasAnyRole(['admin']) && $data->trashed())
        <a href="{{ route('my-home.action',['id' => $data->id, 'type' => 'restore']) }}"
            title="{{ __('messages.restore_form_title',['form' => __('messages.myhome') ]) }}"
            data--submit="confirm_form"
            data--confirmation='true'
            data--ajax='true'
            data-title="{{ __('messages.restore_form_title',['form'=>  __('messages.myhome') ]) }}"
            data-message='{{ __("messages.restore_msg") }}'
            data-datatable="reload"
            class="mr-2">
            <i class="fas fa-redo text-secondary"></i>
        </a>
        <a href="{{ route('my-home.action',['id' => $data->id, 'type' => 'forcedelete']) }}"
            title="{{ __('messages.forcedelete_form_title',['form' => __('messages.myhome') ]) }}"
            data--submit="confirm_form"
            data--confirmation='true'
            data--ajax='true'
            data-title="{{ __('messages.forcedelete_form_title',['form'=>  __('messages.myhome') ]) }}"
            data-message='{{ __("messages.forcedelete_msg") }}'
            data-datatable="reload"
            class="mr-2">
            <i class="far fa-trash-alt text-danger"></i>
        </a>
    @endif
</div>


{{ Form::close() }}