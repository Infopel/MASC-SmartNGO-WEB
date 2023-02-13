@foreach ($subIssues as $sub_issue)
<ul style="list-style:none; line-height: 1.2; padding-left: 20px;">
    <li>
        <a href="{{ route('issues.show', ['issue' => $sub_issue['id']]) }}" class="link-option">
            {{ $sub_issue['tracker'].' #'.$sub_issue['id'] }}
        </a>
        <span style="font-size: 90%;" class="text-black-50">{{ $sub_issue['subject'] }}</span>
    </li>
    @isset($sub_issue['child'])
        @include('issues.sub_tasks_tree', ['subIssues' => $sub_issue['child']])
    @endisset
</ul>
@endforeach
