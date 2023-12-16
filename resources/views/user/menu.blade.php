@php
    use App\Http\Enums\RoleEnum;
    use App\Models\User;
@endphp

<x-button route="web.user.admin-app.index" size="sm"
    color="outline-primary {{ $page == User::ADMIN_APP ? 'active' : '' }}">Admin App</x-button>
<x-button route="web.user.operator.index" size="sm"
    color="outline-primary {{ $page == User::OPERATOR ? 'active' : '' }}">Operator</x-button>
<x-button route="web.user.operator.index" size="sm"
    color="outline-primary {{ $page == User::MEMBER ? 'active' : '' }}">Member Aplikasi</x-button>
