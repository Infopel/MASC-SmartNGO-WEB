<table border="1" style="border-collapse: collapse;">
    <thead>
        <tr>
            <td colspan="5">
                {{-- {{ $application['app_client_short_name'] }} --}}
                <h3 style="color:#27343a; margin-top: -8px; margin-bottom:-5px;">
                    {{ $application['app_client_name'] }}
                </h3>
            </td>
        </tr>
        <tr>
            <td colspan="4"></td>
        </tr>
    </thead>
    <tbody>

        <tr>
            @yield('dataBody')
        </tr>
    </tbody>

</table>
