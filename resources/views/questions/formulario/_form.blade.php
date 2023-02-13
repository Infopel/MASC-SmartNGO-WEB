<label class="floating">
    {{-- @if(in_array('approve_my_issues', $role->permissions ?? []))
        <input type="checkbox" name="role[permissions][]" id="role_permissions_copy_issues" value="approve_my_issues" data-shows=".approve_my_issues_shown" checked="checked">
    @else
        <input type="checkbox" name="role[permissions][]" id="role_permissions_approve_my_issues" value="approve_my_issues" data-shows=".approve_my_issues">
    @endif --}}
    <input type="checkbox" name="form_avaliacaoParceiro[category][]" id="form_avaliacaoParceiro_{{ $question->id }}" value="approve_my_issues" data-shows=".form_avaliacaoParceiro_{{ $question->id }}">
    {{ $question->title }}
</label>
