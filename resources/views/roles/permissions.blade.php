<div class="col-md-12 mb-3">
    <h5>{{ __('lang.label_permissions') }}</h5>
    <div class="bg-light p-2 border">
        <div class="box tabular" id="permissions" style="font-size90%">
            <fieldset class="border pl-3 pr-3 pt-2">
                <legend class="pl-2 pr-2 p-0 m-0 w-auto">Projeto</legend>

                <label class="floating">
                    @if(in_array('add_project', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_add_project" value="add_project" data-shows=".add_project_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_add_project" value="add_project" data-shows=".add_project_shown">
                    @endif
                    Criar projeto
                </label>

                <label class="floating">
                    @if(in_array('edit_project', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_edit_project" value="edit_project" data-shows=".edit_project_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_edit_project" value="edit_project" data-shows=".edit_project_shown">
                    @endif
                    Editar projeto
                </label>

                <label class="floating">
                    @if(in_array('close_project', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_close_project" value="close_project" data-shows=".close_project_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_close_project" value="close_project" data-shows=".close_project_shown">
                    @endif
                    Fechar / reabrir o projeto
                </label>

                {{-- <label class="floating">
                    @if(in_array('select_project_modules', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_select_project_modules" value="select_project_modules" data-shows=".select_project_modules_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_select_project_modules" value="select_project_modules" data-shows=".select_project_modules_shown">
                    @endif
                    Selecionar módulos de projeto
                </label> --}}

                <label class="floating">
                    @if(in_array('manage_members', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_manage_members" value="manage_members" data-shows=".manage_members_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_manage_members" value="manage_members" data-shows=".manage_members_shown">
                    @endif
                    Gerenciar membros
                </label>

                {{-- <label class="floating">
                    @if(in_array('manage_versions', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_manage_versions" value="manage_versions" data-shows=".manage_versions_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_manage_versions" value="manage_versions" data-shows=".manage_versions_shown">
                    @endif
                    Gerenciar versões
                </label> --}}

                <label class="floating">
                    @if(in_array('add_subprojects', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_add_subprojects" value="add_subprojects" data-shows=".add_subprojects_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_add_subprojects" value="add_subprojects" data-shows=".add_subprojects_shown">
                    @endif
                    Criar subprojetos
                </label>

                {{-- <label class="floating">
                    @if(in_array('manage_public_queries', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_manage_public_queries" value="manage_public_queries" data-shows=".manage_public_queries_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_manage_public_queries" value="manage_public_queries" data-shows=".manage_public_queries_shown">
                    @endif
                    Gerenciar consultas públicas
                </label> --}}

                {{-- <label class="floating">
                    @if(in_array('save_queries', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_save_queries" value="save_queries" data-shows=".save_queries_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_save_queries" value="save_queries" data-shows=".save_queries_shown">
                    @endif
                    Salvar consultas
                </label> --}}

            </fieldset>

            {{-- <fieldset class="border pl-3 pr-3 pt-2">
                <legend class="pl-2 pr-2 p-0 m-0 w-auto">Fóruns</legend>

                <label class="floating">
                    @if(in_array('view_messages', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_view_messages" value="view_messages" data-shows=".view_messages_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_view_messages" value="view_messages" data-shows=".view_messages_shown">
                    @endif
                    Ver mensagens
                </label>

                <label class="floating">
                    @if(in_array('add_messages', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_add_messages" value="add_messages" data-shows=".add_messages_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_add_messages" value="add_messages" data-shows=".add_messages_shown">
                    @endif
                    Postar mensagens
                </label>

                <label class="floating">
                    @if(in_array('edit_messages', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_edit_messages" value="edit_messages" data-shows=".edit_messages_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_edit_messages" value="edit_messages" data-shows=".edit_messages_shown">
                    @endif
                    Editar mensagens
                </label>

                <label class="floating">
                    @if(in_array('edit_own_messages', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_edit_own_messages" value="edit_own_messages" data-shows=".edit_own_messages_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_edit_own_messages" value="edit_own_messages" data-shows=".edit_own_messages_shown">
                    @endif
                    Editar próprias mensagens
                </label>

                <label class="floating">
                    @if(in_array('delete_messages', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_delete_messages" value="delete_messages" data-shows=".delete_messages_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_delete_messages" value="delete_messages" data-shows=".delete_messages_shown">
                    @endif
                    Excluir mensagens
                </label>

                <label class="floating">
                    @if(in_array('delete_own_messages', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_delete_own_messages" value="delete_own_messages" data-shows=".delete_own_messages_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_delete_own_messages" value="delete_own_messages" data-shows=".delete_own_messages_shown">
                    @endif
                    Excluir próprias mensagens
                </label>

                <label class="floating">
                    @if(in_array('manage_boards', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_manage_boards" value="manage_boards" data-shows=".manage_boards_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_manage_boards" value="manage_boards" data-shows=".manage_boards_shown">
                    @endif
                    Gerenciar fóruns
                </label>
            </fieldset> --}}

            <fieldset class="border pl-3 pr-3 pt-2">
                <legend class="pl-2 pr-2 p-0 m-0 w-auto">Calendário</legend>

                <label class="floating">
                    @if(in_array('view_calendar', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_view_calendar" value="view_calendar" data-shows=".view_calendar_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_view_calendar" value="view_calendar" data-shows=".view_calendar_shown">
                    @endif
                    Ver calendário
                </label>
            </fieldset>

            <fieldset class="border pl-3 pr-3 pt-2">
                <legend class="pl-2 pr-2 p-0 m-0 w-auto">Documentos</legend>

                <label class="floating">
                    @if(in_array('view_documents', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_view_documents" value="view_documents" data-shows=".view_documents_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_view_documents" value="view_documents" data-shows=".view_documents_shown">
                    @endif
                    Ver documentos
                </label>

                <label class="floating">
                    @if(in_array('add_documents', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_add_documents" value="add_documents" data-shows=".add_documents_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_add_documents" value="add_documents" data-shows=".add_documents_shown">
                    @endif
                    Adicionar documentos
                </label>

                <label class="floating">
                    @if(in_array('edit_documents', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_edit_documents" value="edit_documents" data-shows=".edit_documents_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_edit_documents" value="edit_documents" data-shows=".edit_documents_shown">
                    @endif
                    Editar documentos
                </label>

                <label class="floating">
                    @if(in_array('delete_documents', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_delete_documents" value="delete_documents" data-shows=".delete_documents_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_delete_documents" value="delete_documents" data-shows=".delete_documents_shown">
                    @endif
                    Excluir documentos
                </label>
            </fieldset>

            <fieldset class="border pl-3 pr-3 pt-2">
                <legend class="pl-2 pr-2 p-0 m-0 w-auto">Arquivos</legend>

                <label class="floating">
                    @if(in_array('view_files', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_view_files" value="view_files" data-shows=".view_files_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_view_files" value="view_files" data-shows=".view_files_shown">
                    @endif
                    Ver arquivos
                </label>

                <label class="floating">
                    @if(in_array('manage_files', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_manage_files" value="manage_files" data-shows=".manage_files_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_manage_files" value="manage_files" data-shows=".manage_files_shown">
                    @endif
                    Gerenciar arquivos
                </label>
            </fieldset>

            <fieldset class="border pl-3 pr-3 pt-2">
                <legend class="pl-2 pr-2 p-0 m-0 w-auto">Gantt</legend>
                <label class="floating">
                    @if(in_array('view_gantt', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_view_gantt" value="view_gantt" data-shows=".view_gantt_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_view_gantt" value="view_gantt" data-shows=".view_gantt_shown">
                    @endif
                    Ver gráfico gantt
                </label>
            </fieldset>

            <fieldset class="border pl-3 pr-3 pt-2">
                <legend class="pl-2 pr-2 p-0 m-0 w-auto">Gerenciamento de Tarefas</legend>

                <label class="floating">
                    @if(in_array('view_issues', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_view_issues" value="view_issues" data-shows=".view_issues_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_view_issues" value="view_issues" data-shows=".view_issues_shown">
                    @endif
                    Ver tarefas
                </label>

                <label class="floating">
                    @if(in_array('add_issues', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_add_issues" value="add_issues" data-shows=".add_issues_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_add_issues" value="add_issues" data-shows=".add_issues_shown">
                    @endif
                    Adicionar tarefas
                </label>

                <label class="floating">
                    @if(in_array('edit_issues', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_edit_issues" value="edit_issues" data-shows=".edit_issues_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_edit_issues" value="edit_issues" data-shows=".edit_issues_shown">
                    @endif
                    Editar tarefas
                </label>

                <label class="floating">
                    @if(in_array('copy_issues', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_copy_issues" value="copy_issues" data-shows=".copy_issues_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_copy_issues" value="copy_issues" data-shows=".copy_issues_shown">
                    @endif
                    Copiar tarefas
                </label>

                <label class="floating">
                    @if(in_array('approve_issues', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_copy_issues" value="approve_issues" data-shows=".approve_issues_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_approve_issues" value="approve_issues" data-shows=".approve_issues">
                    @endif
                    {{-- Aprovar tarefas programaticamente --}}
                    Aprovar Tarefas
                </label>
                <label class="floating">
                    @if(in_array('approve_my_issues', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_copy_issues" value="approve_my_issues" data-shows=".approve_my_issues_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_approve_my_issues" value="approve_my_issues" data-shows=".approve_my_issues">
                    @endif
                    Aprovar tarefas criadas por mim
                </label>
                <label class="floating">
                    @if(in_array('approve_issues_prog', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_copy_issues" value="approve_issues_prog" data-shows=".approve_issues_prog_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_approve_issues_prog" value="approve_issues_prog" data-shows=".copy_issues_shown">
                    @endif
                    {{-- Aprovar tarefas programaticamente --}}
                    Aprovar proposta de orçamento
                </label>

                <label class="floating">
                    @if(in_array('approve_issues_budget', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_copy_issues" value="approve_issues_budget" data-shows=".approve_issues_budget_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_approve_issues_budget" value="approve_issues_budget" data-shows=".approve_issues_budget_shown">
                    @endif
                    Aprovar Orçamento de tarefas
                </label>

                <label class="floating">
                    @if(in_array('manage_issue_relations', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_manage_issue_relations" value="manage_issue_relations" data-shows=".manage_issue_relations_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_manage_issue_relations" value="manage_issue_relations" data-shows=".manage_issue_relations_shown">
                    @endif
                    Gerenciar relacionamentos de tarefas
                </label>

                <label class="floating">
                    @if(in_array('manage_subtasks', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_manage_subtasks" value="manage_subtasks" data-shows=".manage_subtasks_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_manage_subtasks" value="manage_subtasks" data-shows=".manage_subtasks_shown">
                    @endif
                    Gerenciar subtarefas
                </label>

                <label class="floating">
                    @if(in_array('set_issues_private', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_set_issues_private" value="set_issues_private" data-shows=".set_issues_private_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_set_issues_private" value="set_issues_private" data-shows=".set_issues_private_shown">
                    @endif
                    Alterar tarefas para públicas ou privadas
                </label>

                <label class="floating">
                    @if(in_array('set_own_issues_private', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_set_own_issues_private" value="set_own_issues_private" data-shows=".set_own_issues_private_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_set_own_issues_private" value="set_own_issues_private" data-shows=".set_own_issues_private_shown">
                    @endif
                    Alterar as próprias tarefas para públicas ou privadas
                </label>

                <label class="floating">
                    @if(in_array('add_issue_notes', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_add_issue_notes" value="add_issue_notes" data-shows=".add_issue_notes_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_add_issue_notes" value="add_issue_notes" data-shows=".add_issue_notes_shown">
                    @endif
                    Adicionar notas
                </label>

                <label class="floating">
                    @if(in_array('edit_issue_notes', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_edit_issue_notes" value="edit_issue_notes" data-shows=".edit_issue_notes_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_edit_issue_notes" value="edit_issue_notes" data-shows=".edit_issue_notes_shown">
                    @endif
                    Editar notas
                </label>

                <label class="floating">
                    @if(in_array('edit_own_issue_notes', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_edit_own_issue_notes" value="edit_own_issue_notes" data-shows=".edit_own_issue_notes_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_edit_own_issue_notes" value="edit_own_issue_notes" data-shows=".edit_own_issue_notes_shown">
                    @endif
                    Editar suas próprias notas
                </label>

                <label class="floating">
                    @if(in_array('view_private_notes', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_view_private_notes" value="view_private_notes" data-shows=".view_private_notes_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_view_private_notes" value="view_private_notes" data-shows=".view_private_notes_shown">
                    @endif
                    Ver notas privadas
                </label>

                <label class="floating">
                    @if(in_array('set_notes_private', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_set_notes_private" value="set_notes_private" data-shows=".set_notes_private_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_set_notes_private" value="set_notes_private" data-shows=".set_notes_private_shown">
                    @endif
                    Permitir alterar notas para privada
                </label>

                <label class="floating">
                    @if(in_array('delete_issues', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_delete_issues" value="delete_issues" data-shows=".delete_issues_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_delete_issues" value="delete_issues" data-shows=".delete_issues_shown">
                    @endif
                    Excluir tarefas
                </label>

                <label class="floating">
                    @if(in_array('view_issue_watchers', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_view_issue_watchers" value="view_issue_watchers" data-shows=".view_issue_watchers_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_view_issue_watchers" value="view_issue_watchers" data-shows=".view_issue_watchers_shown">
                    @endif
                    Ver lista de observadores
                </label>

                <label class="floating">
                    @if(in_array('add_issue_watchers', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_add_issue_watchers" value="add_issue_watchers" data-shows=".add_issue_watchers_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_add_issue_watchers" value="add_issue_watchers" data-shows=".add_issue_watchers_shown">
                    @endif
                    Adicionar observadores
                </label>

                <label class="floating">
                    @if(in_array('delete_issue_watchers', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_delete_issue_watchers" value="delete_issue_watchers" data-shows=".delete_issue_watchers_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_delete_issue_watchers" value="delete_issue_watchers" data-shows=".delete_issue_watchers_shown">
                    @endif
                    Excluir observadores
                </label>

                <label class="floating">
                    @if(in_array('import_issues', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_import_issues" value="import_issues" data-shows=".import_issues_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_import_issues" value="import_issues" data-shows=".import_issues_shown">
                    @endif
                    Importar tarefas
                </label>

                <label class="floating">
                    @if(in_array('manage_categories', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_manage_categories" value="manage_categories" data-shows=".manage_categories_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_manage_categories" value="manage_categories" data-shows=".manage_categories_shown">
                    @endif
                    Gerenciar categorias de tarefas
                </label>
            </fieldset>

            <fieldset class="border pl-3 pr-3 pt-2">
                <legend class="pl-2 pr-2 p-0 m-0 w-auto">Notícias</legend>
                <label class="floating">
                    @if(in_array('view_news', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_view_news" value="view_news" data-shows=".view_news_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_view_news" value="view_news" data-shows=".view_news_shown">
                    @endif
                    Ver notícias
                </label>

                <label class="floating">
                    @if(in_array('manage_news', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_manage_news" value="manage_news" data-shows=".manage_news_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_manage_news" value="manage_news" data-shows=".manage_news_shown">
                    @endif
                    Gerenciar notícias
                </label>

                <label class="floating">
                    @if(in_array('comment_news', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_comment_news" value="comment_news" data-shows=".comment_news_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_comment_news" value="comment_news" data-shows=".comment_news_shown">
                    @endif
                    Comentar notícias
                </label>
            </fieldset>

            {{-- <fieldset class="border pl-3 pr-3 pt-2">
                <legend class="pl-2 pr-2 p-0 m-0 w-auto">Repositório</legend>
                <label class="floating">
                    @if(in_array('view_changesets', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_view_changesets" value="view_changesets" data-shows=".view_changesets_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_view_changesets" value="view_changesets" data-shows=".view_changesets_shown">
                    @endif
                    Ver conjunto de alterações
                </label>

                <label class="floating">
                    @if(in_array('browse_repository', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_browse_repository" value="browse_repository" data-shows=".browse_repository_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_browse_repository" value="browse_repository" data-shows=".browse_repository_shown">
                    @endif
                    Pesquisar repositório
                </label>

                <label class="floating">
                    @if(in_array('commit_access', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_commit_access" value="commit_access" data-shows=".commit_access_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_commit_access" value="commit_access" data-shows=".commit_access_shown">
                    @endif
                    Acesso do commit
                </label>

                <label class="floating">
                    @if(in_array('manage_related_issues', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_manage_related_issues" value="manage_related_issues" data-shows=".manage_related_issues_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_manage_related_issues" value="manage_related_issues" data-shows=".manage_related_issues_shown">
                    @endif
                    Gerenciar tarefas relacionadas
                </label>

                <label class="floating">
                    @if(in_array('manage_repository', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_manage_repository" value="manage_repository" data-shows=".manage_repository_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_manage_repository" value="manage_repository" data-shows=".manage_repository_shown">
                    @endif
                    Gerenciar repositório
                </label>
            </fieldset> --}}

            <fieldset class="border pl-3 pr-3 pt-2">
                <legend class="pl-2 pr-2 p-0 m-0 w-auto">Gerenciamento de tempo</legend>

                <label class="floating">
                    @if(in_array('view_time_entries', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_view_time_entries" value="view_time_entries" data-shows=".view_time_entries_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_view_time_entries" value="view_time_entries" data-shows=".view_time_entries_shown">
                    @endif
                    Ver tempo gasto
                </label>

                <label class="floating">
                    @if(in_array('log_time', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_log_time" value="log_time" data-shows=".log_time_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_log_time" value="log_time" data-shows=".log_time_shown">
                    @endif
                    Adicionar tempo gasto
                </label>

                <label class="floating">
                    @if(in_array('edit_time_entries', $role->permissions ?? []))
                    <input type="checkbox" name="role[permissions][]" id="role_permissions_edit_time_entries" value="edit_time_entries" data-shows=".edit_time_entries_shown" checked="checked">
                    @endif
                    Editar tempo gasto
                </label>

                <label class="floating">
                    @if(in_array('edit_own_time_entries', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_edit_own_time_entries" value="edit_own_time_entries" data-shows=".edit_own_time_entries_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_edit_own_time_entries" value="edit_own_time_entries" data-shows=".edit_own_time_entries_shown">
                    @endif
                    Editar o próprio tempo de trabalho
                </label>

                {{-- <label class="floating">
                    @if(in_array('manage_project_activities', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_manage_project_activities" value="manage_project_activities" data-shows=".manage_project_activities_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_manage_project_activities" value="manage_project_activities" data-shows=".manage_project_activities_shown">
                    @endif
                    Gerenciar atividades do projeto
                </label> --}}
            </fieldset>

            <fieldset class="border pl-3 pr-3 pt-2 mt-2">
                <legend class="pl-2 pr-2 p-0 m-0 w-auto">Wiki</legend>
                <label class="floating">
                    @if(in_array('view_wiki_pages', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_view_wiki_pages" value="view_wiki_pages" data-shows=".view_wiki_pages_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_view_wiki_pages" value="view_wiki_pages" data-shows=".view_wiki_pages_shown">
                    @endif
                    Ver wiki
                </label>

                <label class="floating">
                    @if(in_array('view_wiki_edits', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_view_wiki_edits" value="view_wiki_edits" data-shows=".view_wiki_edits_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_view_wiki_edits" value="view_wiki_edits" data-shows=".view_wiki_edits_shown">
                    @endif
                    Ver histórico do wiki
                </label>

                <label class="floating">
                    @if(in_array('export_wiki_pages', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_export_wiki_pages" value="export_wiki_pages" data-shows=".export_wiki_pages_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_export_wiki_pages" value="export_wiki_pages" data-shows=".export_wiki_pages_shown">
                    @endif
                    Exportar páginas wiki
                </label>

                <label class="floating">
                    @if(in_array('edit_wiki_pages', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_edit_wiki_pages" value="edit_wiki_pages" data-shows=".edit_wiki_pages_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_edit_wiki_pages" value="edit_wiki_pages" data-shows=".edit_wiki_pages_shown">
                    @endif
                    Editar páginas wiki
                </label>

                <label class="floating">
                    @if(in_array('rename_wiki_pages', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_rename_wiki_pages" value="rename_wiki_pages" data-shows=".rename_wiki_pages_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_rename_wiki_pages" value="rename_wiki_pages" data-shows=".rename_wiki_pages_shown">
                    @endif
                    Renomear páginas wiki
                </label>

                <label class="floating">
                    @if(in_array('delete_wiki_pages', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_delete_wiki_pages" value="delete_wiki_pages" data-shows=".delete_wiki_pages_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_delete_wiki_pages" value="delete_wiki_pages" data-shows=".delete_wiki_pages_shown">
                    @endif
                    Excluir páginas wiki
                </label>

                <label class="floating">
                    @if(in_array('delete_wiki_pages_attachments', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_delete_wiki_pages_attachments" value="delete_wiki_pages_attachments" data-shows=".delete_wiki_pages_attachments_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_delete_wiki_pages_attachments" value="delete_wiki_pages_attachments" data-shows=".delete_wiki_pages_attachments_shown">
                    @endif
                    Excluir anexos
                </label>

                <label class="floating">
                    @if(in_array('protect_wiki_pages', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_protect_wiki_pages" value="protect_wiki_pages" data-shows=".protect_wiki_pages_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_protect_wiki_pages" value="protect_wiki_pages" data-shows=".protect_wiki_pages_shown">
                    @endif
                    Proteger páginas wiki
                </label>

                <label class="floating">
                    @if(in_array('manage_wiki', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_manage_wiki" value="manage_wiki" data-shows=".manage_wiki_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_manage_wiki" value="manage_wiki" data-shows=".manage_wiki_shown">
                    @endif
                    Gerenciar wiki
                </label>
            </fieldset>

            <fieldset class="border pl-3 pr-3 pt-2 mt-2">
                <legend class="pl-2 pr-2 p-0 m-0 w-auto">Orçamento</legend>
                <label class="floating">
                    @if(in_array('view_budget', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_view_budget" value="view_budget" data-shows=".view_budget_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_view_budget" value="view_budget" data-shows=".view_budget_shown">
                    @endif
                    Ver Orçamento
                </label>

                <label class="floating">
                    @if(in_array('propose_budget', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_propose_budget" value="propose_budget" data-shows=".propose_budget_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_propose_budget" value="propose_budget" data-shows=".view_budget_shown">
                    @endif
                    Propor Orçamento
                </label>
                <label class="floating">
                    @if(in_array('report_due_budget', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_report_due_budget" value="report_due_budget" data-shows=".report_due_budget_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_report_due_budget" value="report_due_budget" data-shows=".report_due_budget_shown">
                    @endif
                    Reportar orçamento realizado
                </label>

                {{-- <label class="floating">
                    @if(in_array('validate_proposed_budget', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_validate_proposed_budget" value="validate_proposed_budget" data-shows=".validate_proposed_budget_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_validate_proposed_budget" value="validate_proposed_budget" data-shows=".validate_proposed_budget_shown">
                    @endif
                    Validar proposta de orçamento
                </label> --}}

                <label class="floating">
                    @if(in_array('validate_due_budget', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_report_due_budget" value="validate_due_budget" data-shows=".validate_due_budget_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_validate_due_budget" value="validate_due_budget" data-shows=".validate_due_budget_shown">
                    @endif
                    Validar orçamento realizado
                </label>

                {{-- New --}}
                <label class="floating">
                    @if(in_array('view_cabimento_orcamental', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_view_cabimento_orcamental" value="view_cabimento_orcamental" data-shows=".view_cabimento_orcamental_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_view_cabimento_orcamental" value="view_cabimento_orcamental" data-shows=".view_cabimento_orcamental_shown">
                    @endif
                    Ver cabimento orçamental
                </label>

                <label class="floating">
                    @if(in_array('edit_orcamento', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_edit_orcamento" value="edit_orcamento" data-shows=".edit_orcamento_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_edit_orcamento" value="edit_orcamento" data-shows=".edit_orcamento_shown">
                    @endif
                    Editar orçamento
                </label>

                <label class="floating">
                    @if(in_array('view_valor_base', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_report_due_budget" value="view_valor_base" data-shows=".view_valor_base_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_view_valor_base" value="view_valor_base" data-shows=".view_valor_base_shown">
                    @endif
                    Ver valores-base
                </label>

                <label class="floating">
                    @if(in_array('add_valor_base', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_report_due_budget" value="add_valor_base" data-shows=".add_valor_base_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_add_valor_base" value="add_valor_base" data-shows=".add_valor_base_shown">
                    @endif
                    Adicionar valores-base
                </label>

                <label class="floating">
                    @if(in_array('edit_valor_base', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_report_due_budget" value="edit_valor_base" data-shows=".edit_valor_base_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_edit_valor_base" value="edit_valor_base" data-shows=".edit_valor_base_shown">
                    @endif
                    Editar valores-base
                </label>

                <label class="floating">
                    @if(in_array('aprovar_despesas', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_aprovar_realizado_tarefas" value="aprovar_realizado_tarefas" data-shows=".aprovar_realizado_tarefas_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_aprovar_realizado_tarefas" value="aprovar_realizado_tarefas" data-shows=".aprovar_realizado_tarefas_shown">
                    @endif
                    Aprovar realizado de tarefas
                </label>
                <label class="floating">
                    @if(in_array('aprovar_despesas', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_report_due_budget" value="aprovar_despesas" data-shows=".aprovar_despesas_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_aprovar_despesas" value="aprovar_despesas" data-shows=".aprovar_despesas_shown">
                    @endif
                    Aprovar despesas
                </label>

                <label class="floating">
                    @if(in_array('aprovar_plano', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_report_due_budget" value="aprovar_plano" data-shows=".aprovar_plano_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_aprovar_plano" value="aprovar_plano" data-shows=".aprovar_plano_shown">
                    @endif
                    Aprovar plano
                </label>

                <label class="floating">
                    @if(in_array('conferir_plano', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_report_due_budget" value="conferir_plano" data-shows=".conferir_plano_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_conferir_plano" value="conferir_plano" data-shows=".conferir_plano_shown">
                    @endif
                    Conferir plano
                </label>

                <label class="floating">
                    @if(in_array('auth_pagamento', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_report_due_budget" value="auth_pagamento" data-shows=".auth_pagamento_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_auth_pagamento" value="auth_pagamento" data-shows=".auth_pagamento_shown">
                    @endif
                    Autorizar pagamento
                </label>

                <label class="floating">
                    @if(in_array('processar_pagamento', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_report_due_budget" value="processar_pagamento" data-shows=".processar_pagamento_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_processar_pagamento" value="processar_pagamento" data-shows=".processar_pagamento_shown">
                    @endif
                    Processar pagamento
                </label>
                <label class="floating">
                    @if(in_array('validar_pagamento', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_report_due_budget" value="validar_pagamento" data-shows=".validar_pagamento_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_validar_pagamento" value="validar_pagamento" data-shows=".validar_pagamento_shown">
                    @endif
                    Validar pagamento
                </label>

                <label class="floating">
                    @if(in_array('aprovar_pagamento', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_report_due_budget" value="aprovar_pagamento" data-shows=".aprovar_pagamento_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_aprovar_pagamento" value="aprovar_pagamento" data-shows=".aprovar_pagamento_shown">
                    @endif
                    Aprovar pagamento
                </label>

                <label class="floating">
                    @if(in_array('desembolsar_fundos', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_report_due_budget" value="desembolsar_fundos" data-shows=".desembolsar_fundos_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_desembolsar_fundos" value="desembolsar_fundos" data-shows=".desembolsar_fundos_shown">
                    @endif
                    Desembolsar fundos
                </label>

                <label class="floating">
                    @if(in_array('receber_fundos', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_report_due_budget" value="receber_fundos" data-shows=".receber_fundos_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_receber_fundos" value="receber_fundos" data-shows=".receber_fundos_shown">
                    @endif
                    Receber fundos
                </label>

                <label class="floating">
                    @if(in_array('ver_relatorio_solicitacao_fundos', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_report_due_budget" value="ver_relatorio_solicitacao_fundos" data-shows=".ver_relatorio_solicitacao_fundos_shown" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_ver_relatorio_solicitacao_fundos" value="ver_relatorio_solicitacao_fundos" data-shows=".ver_relatorio_solicitacao_fundos_shown">
                    @endif
                    Ver Relatório solicitação de fundos
                </label>

            </fieldset>
            {{-- Aprovação de Plano--}}
            <fieldset class="border pl-3 pr-3 pt-2 mt-2">
                <legend class="pl-2 pr-2 p-0 m-0 w-auto">Aprovação de Plano</legend>
                <label class="floating">
                    @if(in_array('view_programatic_approvement', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_programatic_approvement" value="view_programatic_approvement" data-shows=".view_wiki_programatic_approvement" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_programatic_approvement" value="view_programatic_approvement" data-shows=".view_wiki_programatic_approvement">
                    @endif
                    Aprovação Programatica
                </label>

                <label class="floating">
                    @if(in_array('export_financial_approvement', $role->permissions ?? []))
                    <input type="checkbox" name="role[permissions][]" id="role_permissions_financial_approvement" value="export_financial_approvement" data-shows=".export_financial_approvement" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_financial_approvement" value="export_financial_approvement" data-shows=".export_financial_approvement">
                    @endif
                    Aprovação Financeira
                </label>

                <label class="floating">
                    @if(in_array('export_executive_approvement', $role->permissions ?? []))
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_executive_approvement" value="export_executive_approvement" data-shows=".export_executive_approvement" checked="checked">
                    @else
                        <input type="checkbox" name="role[permissions][]" id="role_permissions_executive_approvement" value="export_executive_approvement" data-shows=".export_executive_approvement">
                    @endif
                    Aprovação Executiva
                </label>


            </fieldset>
            <br>
            <a href="#" onclick="checkAll('permissions', true); return false;">Marcar todos</a> |
            <a href="#" onclick="checkAll('permissions', false); return false;">Desmarcar todos</a>

            <input type="hidden" name="role[permissions][]" id="role_permissions_" value="">
        </div>
    </div>
</div>
