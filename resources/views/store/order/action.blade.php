
<?php
$auth_user= authSession();
?>
{{ Form::open(['route' => ['store-order.destroy', $order->id], 'method' => 'delete','data--submit'=>'booking'.$order->id]) }}
<div class="d-flex justify-content-end align-items-center">
@if(!$order->trashed())
    @if($auth_user->can('booking delete') && !$order->trashed())
    <a class="mr-3" href="{{ route('store-order.destroy', $order->id) }}" data--submit="booking{{$order->id}}" 
        data--confirmation='true'
        data--ajax="true"
        data-datatable="reload"
        data-title="{{ __('messages.delete_form_title',['form'=>  __('messages.order') ]) }}"
        title="{{ __('messages.delete_form_title',['form'=>  __('messages.order') ]) }}"
        data-message='{{ __("messages.delete_msg") }}'>
        <i class="far fa-trash-alt text-danger "></i>
    </a>
    @endif
@endif
@if(auth()->user()->hasAnyRole(['admin']) && $order->trashed())
    <a class="mr-2" href="{{ route('store-order.action',['id' => $order->id, 'type' => 'restore']) }}"
        title="{{ __('messages.restore_form_title',['form' => __('messages.order') ]) }}"
        data--submit="confirm_form"
        data--confirmation='true'
        data--ajax='true'
        data-title="{{ __('messages.restore_form_title',['form'=>  __('messages.order') ]) }}"
        data-message='{{ __("messages.restore_msg") }}'
        data-datatable="reload">
        <i class="fas fa-redo text-secondary"></i>
    </a>
    <a href="{{ route('store-order.action',['id' => $order->id, 'type' => 'forcedelete']) }}"
        title="{{ __('messages.forcedelete_form_title',['form' => __('messages.order') ]) }}"
        data--submit="confirm_form"
        data--confirmation='true'
        data--ajax='true'
        data-title="{{ __('messages.forcedelete_form_title',['form'=>  __('messages.order') ]) }}"
        data-message='{{ __("messages.forcedelete_msg") }}'
        data-datatable="reload"
        class="mr-2">
        <i class="far fa-trash-alt text-danger"></i>
    </a>
@endif
</div>
{{ Form::close() }}