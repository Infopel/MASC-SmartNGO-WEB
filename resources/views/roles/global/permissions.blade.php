<div class="box" id="permissions" style="font-size:90%">

    <label class="floating">
        @if(in_array('gerir_painel_admin', $role_available_permissions ?? []))
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_gerir_painel_admin" value="gerir_painel_admin" data-shows=".gerir_painel_admin_shown" checked="checked">
        @else
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_gerir_painel_admin" value="gerir_painel_admin" data-shows=".gerir_painel_admin_shown">
        @endif
        Gerir painel Administrativo
    </label>

    <label class="floating">
        @if(in_array('ver_tipos_categorias', $role_available_permissions ?? []))
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_ver_tipos_categorias" value="ver_tipos_categorias" data-shows=".ver_tipos_categorias_shown" checked="checked">
        @else
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_ver_tipos_categorias" value="ver_tipos_categorias" data-shows=".ver_tipos_categorias_shown">
        @endif
        Ver Tipos e Categorias
    </label>


    <label class="floating">
        @if(in_array('criar_tipos_categorias', $role_available_permissions ?? []))
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_criar_tipos_categorias" value="criar_tipos_categorias" data-shows=".criar_tipos_categorias_shown" checked="checked">
        @else
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_criar_tipos_categorias" value="criar_tipos_categorias" data-shows=".criar_tipos_categorias_shown">
        @endif
        Criar Tipos e Categorias
    </label>


    <label class="floating">
        @if(in_array('editar_tipos_categorias', $role_available_permissions ?? []))
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_editar_tipos_categorias" value="editar_tipos_categorias" data-shows=".editar_tipos_categorias_shown" checked="checked">
        @else
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_editar_tipos_categorias" value="editar_tipos_categorias" data-shows=".editar_tipos_categorias_shown">
        @endif
        Editar Tipos e Categorias
    </label>

    <label class="floating">
        @if(in_array('excluir_tipos_categorias', $role_available_permissions ?? []))
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_excluir_tipos_categorias" value="excluir_tipos_categorias" data-shows=".excluir_tipos_categorias_shown" checked="checked">
        @else
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_excluir_tipos_categorias" value="excluir_tipos_categorias" data-shows=".excluir_tipos_categorias_shown">
        @endif
        Excluir Tipos e Categorias
    </label>

    <label class="floating">
        @if(in_array('ver_usuarios', $role_available_permissions ?? []))
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_ver_usuarios" value="ver_usuarios" data-shows=".ver_usuarios_shown" checked="checked">
        @else
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_ver_usuarios" value="ver_usuarios" data-shows=".ver_usuarios_shown">
        @endif
        Ver lista de usuarios
    </label>

    <label class="floating">
        @if(in_array('cadastrar_usuarios', $role_available_permissions ?? []))
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_cadastrar_usuarios" value="cadastrar_usuarios" data-shows=".cadastrar_usuarios_shown" checked="checked">
        @else
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_cadastrar_usuarios" value="cadastrar_usuarios" data-shows=".cadastrar_usuarios_shown">
        @endif
        Cadastrar Usuarios
    </label>

    <label class="floating">
        @if(in_array('alterar_senha_de_usuarios', $role_available_permissions ?? []))
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_alterar_senha_de_usuarios" value="alterar_senha_de_usuarios" data-shows=".alterar_senha_de_usuarios_shown" checked="checked">
        @else
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_alterar_senha_de_usuarios" value="alterar_senha_de_usuarios" data-shows=".alterar_senha_de_usuarios_shown">
        @endif
        ALterar Senha de Usuarios
    </label>

    <label class="floating">
        @if(in_array('bloquear_desbloquar_usuarios', $role_available_permissions ?? []))
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_bloquear_desbloquar_usuarios" value="bloquear_desbloquar_usuarios" data-shows=".bloquear_desbloquar_usuarios_shown" checked="checked">
        @else
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_bloquear_desbloquar_usuarios" value="bloquear_desbloquar_usuarios" data-shows=".bloquear_desbloquar_usuarios_shown">
        @endif
        Bloquear & Desbloquear usuarios
    </label>

    <label class="floating">
        @if(in_array('remover_usuarios', $role_available_permissions ?? []))
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_remover_usuarios" value="remover_usuarios" data-shows=".remover_usuarios_shown" checked="checked">
        @else
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_remover_usuarios" value="remover_usuarios" data-shows=".remover_usuarios_shown">
        @endif
        Remover Usuarios
    </label>


    <label class="floating">
        @if(in_array('cadastrar_plano_estrategico', $role_available_permissions ?? []))
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_cadastrar_plano_estrategico" value="cadastrar_plano_estrategico" data-shows=".cadastrar_plano_estrategico_shown" checked="checked">
        @else
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_cadastrar_plano_estrategico" value="cadastrar_plano_estrategico" data-shows=".cadastrar_plano_estrategico_shown">
        @endif
        Criar Plano Estratégico
    </label>

    <label class="floating">
        @if(in_array('editar_plano_estrategico', $role_available_permissions ?? []))
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_editar_plano_estrategico" value="editar_plano_estrategico" data-shows=".editar_plano_estrategico_shown" checked="checked">
        @else
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_editar_plano_estrategico" value="editar_plano_estrategico" data-shows=".editar_plano_estrategico_shown">
        @endif
        Editar Plano Estratégico
    </label>

    <label class="floating">
        @if(in_array('excluir_plano_estrategico', $role_available_permissions ?? []))
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_excluir_plano_estrategico" value="excluir_plano_estrategico" data-shows=".excluir_plano_estrategico_shown" checked="checked">
        @else
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_excluir_plano_estrategico" value="excluir_plano_estrategico" data-shows=".excluir_plano_estrategico_shown">
        @endif
        Excluir Plano Estratégico
    </label>

    <label class="floating">
        @if(in_array('arquivar_plano_estrategico', $role_available_permissions ?? []))
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_arquivar_plano_estrategico" value="arquivar_plano_estrategico" data-shows=".arquivar_plano_estrategico_shown" checked="checked">
        @else
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_arquivar_plano_estrategico" value="arquivar_plano_estrategico" data-shows=".arquivar_plano_estrategico_shown">
        @endif
        Arquivar Plano Estratégico
    </label>

    <label class="floating">
        @if(in_array('gerir_linhas_estrategicas', $role_available_permissions ?? []))
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_gerir_linhas_estrategicas" value="gerir_linhas_estrategicas" data-shows=".gerir_linhas_estrategicas_shown" checked="checked">
        @else
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_gerir_linhas_estrategicas" value="gerir_linhas_estrategicas" data-shows=".gerir_linhas_estrategicas_shown">
        @endif
        Gerir Linhas Estrategicas
    </label>

    <label class="floating">
        @if(in_array('criar_linhas_estrategicas', $role_available_permissions ?? []))
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_criar_linhas_estrategicas" value="criar_linhas_estrategicas" data-shows=".criar_linhas_estrategicas_shown" checked="checked">
        @else
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_criar_linhas_estrategicas" value="criar_linhas_estrategicas" data-shows=".criar_linhas_estrategicas_shown">
        @endif
        Criar Linhas Estrategicas
    </label>

    <label class="floating">
        @if(in_array('editar_linhas_estrategicas', $role_available_permissions ?? []))
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_editar_linhas_estrategicas" value="editar_linhas_estrategicas" data-shows=".editar_linhas_estrategicas_shown" checked="checked">
        @else
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_editar_linhas_estrategicas" value="editar_linhas_estrategicas" data-shows=".editar_linhas_estrategicas_shown">
        @endif
        Editar Linhas Estrategicas
    </label>

    <label class="floating">
        @if(in_array('excluir_linhas_estrategicas', $role_available_permissions ?? []))
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_excluir_linhas_estrategicas" value="excluir_linhas_estrategicas" data-shows=".excluir_linhas_estrategicas_shown" checked="checked">
        @else
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_excluir_linhas_estrategicas" value="excluir_linhas_estrategicas" data-shows=".excluir_linhas_estrategicas_shown">
        @endif
        Excluir Linhas Estrategicas
    </label>

    <label class="floating">
        @if(in_array('gerir_projectos', $role_available_permissions ?? []))
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_gerir_projectos" value="gerir_projectos" data-shows=".gerir_projectos_shown" checked="checked">
        @else
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_gerir_projectos" value="gerir_projectos" data-shows=".gerir_projectos_shown">
        @endif
        Gerir Projectos
    </label>

    <label class="floating">
        @if(in_array('cadastrar_projectos', $role_available_permissions ?? []))
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_cadastrar_projectos" value="cadastrar_projectos" data-shows=".cadastrar_projectos_shown" checked="checked">
        @else
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_cadastrar_projectos" value="cadastrar_projectos" data-shows=".cadastrar_projectos_shown">
        @endif
        Cadastrar Projectos
    </label>

    <label class="floating">
        @if(in_array('editar_projectos', $role_available_permissions ?? []))
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_editar_projectos" value="editar_projectos" data-shows=".editar_projectos_shown" checked="checked">
        @else
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_editar_projectos" value="editar_projectos" data-shows=".editar_projectos_shown">
        @endif
        Editar Projectos
    </label>

    <label class="floating">
        @if(in_array('excluir_projectos', $role_available_permissions ?? []))
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_excluir_projectos" value="excluir_projectos" data-shows=".excluir_projectos_shown" checked="checked">
        @else
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_excluir_projectos" value="excluir_projectos" data-shows=".excluir_projectos_shown">
        @endif
        Excluir Projectos
    </label>


    <label class="floating">
        @if(in_array('arquivar_projeto', $role_available_permissions ?? []))
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_arquivar_projeto" value="arquivar_projeto" data-shows=".arquivar_projeto_shown" checked="checked">
        @else
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_arquivar_projeto" value="arquivar_projeto" data-shows=".arquivar_projeto_shown">
        @endif
        Arquivar Projectos
    </label>

    {{-- <label class="floating">
        @if(in_array('definir_niveis_acesso', $role_available_permissions ?? []))
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_definir_niveis_acesso" value="definir_niveis_acesso" data-shows=".definir_niveis_acesso_shown" checked="checked">
        @else
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_definir_niveis_acesso" value="definir_niveis_acesso" data-shows=".definir_niveis_acesso_shown">
        @endif
        Definir Niveis de Acesso
    </label> --}}

    <label class="floating">
        @if(in_array('cadastrar_parceiros', $role_available_permissions ?? []))
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_cadastrar_parceiros" value="cadastrar_parceiros" data-shows=".cadastrar_parceiros_shown" checked="checked">
        @else
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_cadastrar_parceiros" value="cadastrar_parceiros" data-shows=".cadastrar_parceiros_shown">
        @endif
        Cadastrar Parceiros
    </label>

    <label class="floating">
        @if(in_array('remover_parceiros', $role_available_permissions ?? []))
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_remover_parceiros" value="remover_parceiros" data-shows=".remover_parceiros_shown" checked="checked">
        @else
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_remover_parceiros" value="remover_parceiros" data-shows=".remover_parceiros_shown">
        @endif
        Excluir Parceiros
    </label>

    <label class="floating">
        @if(in_array('definir_modelos_avaliacao', $role_available_permissions ?? []))
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_definir_modelos_avaliacao" value="definir_modelos_avaliacao" data-shows=".definir_modelos_avaliacao_shown" checked="checked">
        @else
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_definir_modelos_avaliacao" value="definir_modelos_avaliacao" data-shows=".definir_modelos_avaliacao_shown">
        @endif
        Definir Modelos de Avaliação
    </label>

    <label class="floating">
        @if(in_array('avaliar_parceiros', $role_available_permissions ?? []))
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_avaliar_parceiros" value="avaliar_parceiros" data-shows=".avaliar_parceiros_shown" checked="checked">
        @else
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_avaliar_parceiros" value="avaliar_parceiros" data-shows=".avaliar_parceiros_shown">
        @endif
        Avaliar parceiros
    </label>

    <label class="floating">
        @if(in_array('gerir_tipos_tarefas', $role_available_permissions ?? []))
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_gerir_tipos_tarefas" value="gerir_tipos_tarefas" data-shows=".gerir_tipos_tarefas_shown" checked="checked">
        @else
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_gerir_tipos_tarefas" value="gerir_tipos_tarefas" data-shows=".gerir_tipos_tarefas_shown">
        @endif
        Gerir tipos de tarefas
    </label>

    <label class="floating">
        @if(in_array('gerir_estados_tarefas', $role_available_permissions ?? []))
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_gerir_estados_tarefas" value="gerir_estados_tarefas" data-shows=".gerir_estados_tarefas_shown" checked="checked">
        @else
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_gerir_estados_tarefas" value="gerir_estados_tarefas" data-shows=".gerir_estados_tarefas_shown">
        @endif
        Gerir estados de tarefas
    </label>

    <label class="floating">
        @if(in_array('gerir_campos_personalizados', $role_available_permissions ?? []))
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_gerir_campos_personalizados" value="gerir_campos_personalizados" data-shows=".gerir_campos_personalizados_shown" checked="checked">
        @else
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_gerir_campos_personalizados" value="gerir_campos_personalizados" data-shows=".gerir_campos_personalizados_shown">
        @endif
        Gerir Campos Personalizados
    </label>

    <label class="floating">
        @if(in_array('cadastrar_campos_personalizados', $role_available_permissions ?? []))
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_cadastrar_campos_personalizados" value="cadastrar_campos_personalizados" data-shows=".cadastrar_campos_personalizados_shown" checked="checked">
        @else
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_cadastrar_campos_personalizados" value="cadastrar_campos_personalizados" data-shows=".cadastrar_campos_personalizados_shown">
        @endif
        Cadastrar campos personlizados
    </label>

    <label class="floating">
        @if(in_array('editar_campos_personalizados', $role_available_permissions ?? []))
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_editar_campos_personalizados" value="editar_campos_personalizados" data-shows=".editar_campos_personalizados_shown" checked="checked">
        @else
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_editar_campos_personalizados" value="editar_campos_personalizados" data-shows=".editar_campos_personalizados_shown">
        @endif
        Editar campos personlizados
    </label>

    <label class="floating">
        @if(in_array('excluir_campos_personalizados', $role_available_permissions ?? []))
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_excluir_campos_personalizados" value="excluir_campos_personalizados" data-shows=".excluir_campos_personalizados_shown" checked="checked">
        @else
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_excluir_campos_personalizados" value="excluir_campos_personalizados" data-shows=".excluir_campos_personalizados_shown">
        @endif
        Excluir campos personalizados
    </label>

    <label class="floating">
        @if(in_array('config_orcamento_projectos', $role_available_permissions ?? []))
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_config_orcamento_projectos" value="config_orcamento_projectos" data-shows=".config_orcamento_projectos_shown" checked="checked">
        @else
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_config_orcamento_projectos" value="config_orcamento_projectos" data-shows=".config_orcamento_projectos_shown">
        @endif
        Configuração de orçamento de projectos
    </label>

    <label class="floating">
        @if(in_array('cadastrar_rubricas_projecto', $role_available_permissions ?? []))
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_cadastrar_rubricas_projecto" value="cadastrar_rubricas_projecto" data-shows=".cadastrar_rubricas_projecto_shown" checked="checked">
        @else
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_cadastrar_rubricas_projecto" value="cadastrar_rubricas_projecto" data-shows=".cadastrar_rubricas_projecto_shown">
        @endif
        Cadastrar rubricas de projectos
    </label>

    <label class="floating">
        @if(in_array('atualizar_rubricas_projecto', $role_available_permissions ?? []))
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_atualizar_rubricas_projecto" value="atualizar_rubricas_projecto" data-shows=".atualizar_rubricas_projecto_shown" checked="checked">
        @else
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_atualizar_rubricas_projecto" value="atualizar_rubricas_projecto" data-shows=".atualizar_rubricas_projecto_shown">
        @endif
        Atualizar rubricas de projectos
    </label>

    <label class="floating">
        @if(in_array('excluir_rubricas_projecto', $role_available_permissions ?? []))
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_excluir_rubricas_projecto" value="excluir_rubricas_projecto" data-shows=".excluir_rubricas_projecto_shown" checked="checked">
        @else
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_excluir_rubricas_projecto" value="excluir_rubricas_projecto" data-shows=".excluir_rubricas_projecto_shown">
        @endif
        Excluir rubricas de projectos
    </label>

    <label class="floating">
        @if(in_array('cadastrar_tipos_despesa', $role_available_permissions ?? []))
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_cadastrar_tipos_despesa" value="cadastrar_tipos_despesa" data-shows=".cadastrar_tipos_despesa_shown" checked="checked">
        @else
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_cadastrar_tipos_despesa" value="cadastrar_tipos_despesa" data-shows=".cadastrar_tipos_despesa_shown">
        @endif
        Cadastrar Tipos de Despesa
    </label>


    <label class="floating">
        @if(in_array('atualizar_tipos_despesa', $role_available_permissions ?? []))
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_atualizar_tipos_despesa" value="atualizar_tipos_despesa" data-shows=".atualizar_tipos_despesa_shown" checked="checked">
        @else
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_atualizar_tipos_despesa" value="atualizar_tipos_despesa" data-shows=".atualizar_tipos_despesa_shown">
        @endif
        Atualizar Tipos de Despesa
    </label>

    <label class="floating">
        @if(in_array('excluir_tipos_despesa', $role_available_permissions ?? []))
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_excluir_tipos_despesa" value="excluir_tipos_despesa" data-shows=".excluir_tipos_despesa_shown" checked="checked">
        @else
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_excluir_tipos_despesa" value="excluir_tipos_despesa" data-shows=".excluir_tipos_despesa_shown">
        @endif
        Excluir Tipos de Despesa
    </label>
{{--
    <label class="floating">
        @if(in_array('gerir_valor_base', $role_available_permissions ?? []))
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_gerir_valor_base" value="gerir_valor_base" data-shows=".gerir_valor_base_shown" checked="checked">
        @else
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_gerir_valor_base" value="gerir_valor_base" data-shows=".gerir_valor_base_shown">
        @endif
        Gerir Valor Base
    </label> --}}

    <label class="floating">
        @if(in_array('cadastrar_valores_base', $role_available_permissions ?? []))
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_cadastrar_valores_base" value="cadastrar_valores_base" data-shows=".cadastrar_valores_base_shown" checked="checked">
        @else
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_cadastrar_valores_base" value="cadastrar_valores_base" data-shows=".cadastrar_valores_base_shown">
        @endif
        Cadastrar Valor Base
    </label>

    <label class="floating">
        @if(in_array('atualizar_valores_base', $role_available_permissions ?? []))
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_atualizar_valores_base" value="atualizar_valores_base" data-shows=".atualizar_valores_base_shown" checked="checked">
        @else
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_atualizar_valores_base" value="atualizar_valores_base" data-shows=".atualizar_valores_base_shown">
        @endif
        Atualizar Valor Base
    </label>

    <label class="floating">
        @if(in_array('ver_permisoes', $role_available_permissions ?? []))
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_ver_permisoes" value="ver_permisoes" data-shows=".ver_permisoes_shown" checked="checked">
        @else
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_ver_permisoes" value="ver_permisoes" data-shows=".ver_permisoes_shown">
        @endif
        Ver Permissões
    </label>

    <label class="floating">
        @if(in_array('excluir_permissoes', $role_available_permissions ?? []))
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_excluir_permissoes" value="excluir_permissoes" data-shows=".excluir_permissoes_shown" checked="checked">
        @else
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_excluir_permissoes" value="excluir_permissoes" data-shows=".excluir_permissoes_shown">
        @endif
        Excluir Permissões
    </label>

    <label class="floating">
        @if(in_array('criar_permissoes', $role_available_permissions ?? []))
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_criar_permissoes" value="criar_permissoes" data-shows=".criar_permissoes_shown" checked="checked">
        @else
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_criar_permissoes" value="criar_permissoes" data-shows=".criar_permissoes_shown">
        @endif
        Criar Permissões
    </label>

    <label class="floating">
        @if(in_array('atualizar_permissoes', $role_available_permissions ?? []))
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_atualizar_permissoes" value="atualizar_permissoes" data-shows=".atualizar_permissoes_shown" checked="checked">
        @else
            <input type="checkbox" name="role[permissions][]" wire:model="role_permissions" id="role_atualizar_permissoes" value="atualizar_permissoes" data-shows=".atualizar_permissoes_shown">
        @endif
        Atualizar Permissões
    </label>
    {{-- <input type="hidden" name="role[permissions][]" wire:model="role_permissions" id="role_permissions_" value=""> --}}
</div>
