<label class="floating">
    @if(in_array('gerir_painel_admin', $role_available_permissions ?? []))
        Gerir painel Administrativo
    @endif
</label>

<label class="floating">
    @if(in_array('ver_tipos_categorias', $role_available_permissions ?? []))
        Ver Tipos e Categorias
    @endif
</label>

<label class="floating">
    @if(in_array('criar_tipos_categorias', $role_available_permissions ?? []))
        Criar Tipos e Categorias
    @endif
</label>

<label class="floating">
    @if(in_array('editar_tipos_categorias', $role_available_permissions ?? []))
        Editar Tipos e Categorias
    @endif
</label>

<label class="floating">
    @if(in_array('excluir_tipos_categorias', $role_available_permissions ?? []))
        Excluir Tipos e Categorias
    @endif
</label>

<label class="floating">
    @if(in_array('ver_usuarios', $role_available_permissions ?? []))
        Ver lista de usuarios
    @endif
</label>

<label class="floating">
    @if(in_array('cadastrar_usuarios', $role_available_permissions ?? []))
        Cadastrar Usuarios
    @endif
</label>

<label class="floating">
    @if(in_array('alterar_senha_de_usuarios', $role_available_permissions ?? []))
        ALterar Senha de Usuarios
    @endif
</label>

<label class="floating">
    @if(in_array('bloquear_desbloquar_usuarios', $role_available_permissions ?? []))
        Bloquear & Desbloquear usuarios
    @endif
</label>

<label class="floating">
    @if(in_array('remover_usuarios', $role_available_permissions ?? []))
        Remover Usuarios
    @endif
</label>

<label class="floating">
    @if(in_array('gerir_linhas_estrategicas', $role_available_permissions ?? []))
        Gerir Linhas Estrategicas
    @endif
</label>

<label class="floating">
    @if(in_array('cadastrar_projectos', $role_available_permissions ?? []))
        Cadastrar Projectos
    @endif
</label>

<label class="floating">
    @if(in_array('gerir_projectos', $role_available_permissions ?? []))
        Gerir Projectos
    @endif
</label>

<label class="floating">
    @if(in_array('arquivar_projeto', $role_available_permissions ?? []))
        Arquivar Projectos
    @endif
</label>

<label class="floating">
    @if(in_array('arquivar_pe', $role_available_permissions ?? []))
        Arquivar PE
    @endif
</label>

<label class="floating">
    @if(in_array('excluir_pe', $role_available_permissions ?? []))
        Excluir PE
    @endif
</label>

<label class="floating">
    @if(in_array('excluir_projecto', $role_available_permissions ?? []))
        Excluir Projectos
    @endif
</label>

<label class="floating">
    @if(in_array('definir_niveis_acesso', $role_available_permissions ?? []))
        Definir Niveis de Acesso
    @endif
</label>

<label class="floating">
    @if(in_array('cadastrar_parceiros', $role_available_permissions ?? []))
        Cadastrar Parceiros
    @endif
</label>

<label class="floating">
    @if(in_array('editar_parceiros', $role_available_permissions ?? []))
        Editar Parceiros
    @endif
</label>

<label class="floating">
    @if(in_array('remover_parceiros', $role_available_permissions ?? []))
        Excluir Parceiros
    @endif
</label>

<label class="floating">
    @if(in_array('definir_modelos_avaliacao', $role_available_permissions ?? []))
        Definir Modelos de Avaliação
    @endif
</label>

<label class="floating">
    @if(in_array('avaliar_parceiros', $role_available_permissions ?? []))
        Avaliar parceiros
    @endif
</label>

<label class="floating">
    @if(in_array('gerir_tipos_tarefas', $role_available_permissions ?? []))
        Gerir tipos de tarefas
    @endif
</label>

<label class="floating">
    @if(in_array('gerir_estados_tarefas', $role_available_permissions ?? []))
        Gerir estados de tarefas
    @endif
</label>

<label class="floating">
    @if(in_array('gerir_campos_personalizados', $role_available_permissions ?? []))
        Gerir Campos Personalizados
    @endif
</label>

<label class="floating">
    @if(in_array('cadastrar_campos_personalizados', $role_available_permissions ?? []))
        Cadastrar campos personlizados
    @endif
</label>

<label class="floating">
    @if(in_array('editar_campos_personalizados', $role_available_permissions ?? []))
         Editar campos personlizados
    @endif
</label>

<label class="floating">
    @if(in_array('excluir_campos_personalizados', $role_available_permissions ?? []))
         Excluir campos personalizados
    @endif
</label>

<label class="floating">
    @if(in_array('gerir_tipos_categorias', $role_available_permissions ?? []))
        Gerir tipos e categorias
    @endif
</label>


<label class="floating">
    @if(in_array('config_orcamento_projectos', $role_available_permissions ?? []))
        Configuração de orçamento de projectos
    @endif
</label>

<label class="floating">
    @if(in_array('cadastrar_rubricas_projecto', $role_available_permissions ?? []))
        Cadastrar rubricas de projectos
    @endif
</label>

<label class="floating">
    @if(in_array('atualizar_rubricas_projecto', $role_available_permissions ?? []))
        Atualizar rubricas de projectos
    @endif
</label>

<label class="floating">
    @if(in_array('excluir_rubricas_projecto', $role_available_permissions ?? []))
        Excluir rubricas de projectos
    @endif
</label>

<label class="floating">
    @if(in_array('cadastrar_tipos_despesa', $role_available_permissions ?? []))
        Cadastrar Tipos de Despesa
    @endif
</label>

<label class="floating">
    @if(in_array('atualizar_tipos_despesa', $role_available_permissions ?? []))
        Atualizar Tipos de Despesa
    @endif
</label>

<label class="floating">
    @if(in_array('excluir_tipos_despesa', $role_available_permissions ?? []))
        Excluir Tipos de Despesa
    @endif
</label>

<label class="floating">
    @if(in_array('cadastrar_valores_base', $role_available_permissions ?? []))
        Cadastrar Valor Base
    @endif
</label>

<label class="floating">
    @if(in_array('atualizar_valores_base', $role_available_permissions ?? []))
        Atualizar Valor Base
    @endif
</label>

<label class="floating">
    @if(in_array('ver_permisoes', $role_available_permissions ?? []))
        Ver Permissões
    @endif
</label>

<label class="floating">
    @if(in_array('excluir_permissoes', $role_available_permissions ?? []))
         Excluir Permissões
    @endif
</label>

<label class="floating">
    @if(in_array('criar_permissoes', $role_available_permissions ?? []))
        Criar Permissões
    @endif
</label>

<label class="floating">
    @if(in_array('atualizar_permissoes', $role_available_permissions ?? []))
        Atualizar Permissões
    @endif
</label>
