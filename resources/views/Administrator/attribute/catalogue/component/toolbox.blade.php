<div class="ibox-tools">
    <a class="collapse-link">
        <i class="fa fa-chevron-up"></i>
    </a>
    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        <i class="fa fa-wrench"></i>
    </a>
    <ul class="dropdown-menu dropdown-user">
        <li>
            <a href="" class="changeStatasAll" data-field="publish" data-model="{{ $config['model'] }}"
                data-value="1">{{ __('messages.change_status') }}</a>
        </li>
        <li>
            <a href="" class="changeStatasAll" data-field="publish" data-model="{{ $config['model'] }}"
                data-value="0">{{ __('messages.cancel_status_change') }}</a>
        </li>
    </ul>
    <a class="close-link">
        <i class="fa fa-times"></i>
    </a>
</div>
