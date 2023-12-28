<div id="sidebar" class="c-sidebar c-sidebar-fixed c-sidebar-lg-show">

    <div class="c-sidebar-brand d-md-down-none">
        <a class="c-sidebar-brand-full h4" href="#">
            {{ trans('panel.site_title') }}
        </a>
    </div>

    <ul class="c-sidebar-nav">
        <li>
            <select class="searchable-field form-control">

            </select>
        </li>
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.home") }}" class="c-sidebar-nav-link">
                <i class="c-sidebar-nav-icon fas fa-fw fa-tachometer-alt">

                </i>
                {{ trans('global.dashboard') }}
            </a>
        </li>
        @can('user_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/permissions*") ? "c-show" : "" }} {{ request()->is("admin/roles*") ? "c-show" : "" }} {{ request()->is("admin/users*") ? "c-show" : "" }} {{ request()->is("admin/audit-logs*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.userManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('permission_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.permissions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-unlock-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.permission.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('role_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.roles.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-briefcase c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.role.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('user_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.users.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.user.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('audit_log_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.audit-logs.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/audit-logs") || request()->is("admin/audit-logs/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-file-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.auditLog.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('data_source_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.data-sources.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/data-sources") || request()->is("admin/data-sources/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-database c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.dataSource.title') }}
                </a>
            </li>
        @endcan
        @can('data_category_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.data-categories.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/data-categories") || request()->is("admin/data-categories/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-table c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.dataCategory.title') }}
                </a>
            </li>
        @endcan
        @can('extracted_data_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.extracted-datas.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/extracted-datas") || request()->is("admin/extracted-datas/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-sitemap c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.extractedData.title') }}
                </a>
            </li>
        @endcan
        @can('query_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.queries.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/queries") || request()->is("admin/queries/*") ? "c-active" : "" }}">
                    <i class="fa-fw far fa-comments c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.query.title') }}
                </a>
            </li>
        @endcan
        @can('query_message_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.query-messages.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/query-messages") || request()->is("admin/query-messages/*") ? "c-active" : "" }}">
                    <i class="fa-fw far fa-comment c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.queryMessage.title') }}
                </a>
            </li>
        @endcan
        @can('report_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.reports.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/reports") || request()->is("admin/reports/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-file-alt c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.report.title') }}
                </a>
            </li>
        @endcan
        @can('setting_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.settings.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/settings") || request()->is("admin/settings/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.setting.title') }}
                </a>
            </li>
        @endcan
        @can('moderation_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.moderations.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/moderations") || request()->is("admin/moderations/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-exclamation-circle c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.moderation.title') }}
                </a>
            </li>
        @endcan
        @can('error_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.errors.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/errors") || request()->is("admin/errors/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-exclamation-triangle c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.error.title') }}
                </a>
            </li>
        @endcan
        @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
            @can('profile_password_edit')
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'c-active' : '' }}" href="{{ route('profile.password.edit') }}">
                        <i class="fa-fw fas fa-key c-sidebar-nav-icon">
                        </i>
                        {{ trans('global.change_password') }}
                    </a>
                </li>
            @endcan
        @endif
        <li class="c-sidebar-nav-item">
            <a href="#" class="c-sidebar-nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                <i class="c-sidebar-nav-icon fas fa-fw fa-sign-out-alt">

                </i>
                {{ trans('global.logout') }}
            </a>
        </li>
    </ul>

</div>