@foreach ($subIssues as $sub_issue)
<ul style="list-style:none; line-height: 1.2; padding-left: 20px;">
    @if ($sub_issue->tracker_id == $data['tracker_id'])
        <li>
            <span class="h5">{{ $sub_issue->subject }}</span>
        </li>
    @else
        <li>
            <a href="{{ route('issues.show', ['issue' => $sub_issue['id']]) }}" class="link-option">
                {{ $sub_issue['tracker'].' #'.$sub_issue['id'] }}
            </a>
            <span style="font-size: 90%;" class="text-black-50">{{ $sub_issue['subject'] }}</span>
        </li>
    @endif
    @isset($sub_issue['child'])
        @include('issues.sub_tree', ['subIssues' => $sub_issue['child']])
    @endisset
</ul>
@endforeach
