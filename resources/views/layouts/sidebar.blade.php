<aside>
    <div class="nav_section">
        <div class="nav_section_logo">
            <h3>LindenCMS</h3>
        </div>
        <nav>
            <div class="group">Dashboard</div>
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <x-cms::i icon="boxicons:dashboard-filled" width="18" height="18" />
                <span>Dashboard</span>
            </a>
            @foreach (config('lindencms.navigation') as $group => $nodes)
                <div class="group">{{ $group }}</div>
                @foreach ($nodes as $nodeClass)
                    @php
                        $node = $nodeClass::make();
                    @endphp

                    {!! $node->ctx()->html_sidebarLink(request()->route('code') == $node->code() ? 'active' : '') !!}
                @endforeach
            @endforeach
        </nav>
    </div>

    @php
        $id = auth()->id();
        $user = LindenCMS\Cms\User::make();
        $user->ctx()->db_refresh($id);

        $userRoute = route('nodes.edit', [
            'code' => $user->code(),
            'id' => $user->id->get(),
        ]);
    @endphp
    <div class="profile_section">
        <div class="profile_section_avatar">
            <img src="{{ $user->image?->file()?->src() }}"/>
        </div>
        <div class="profile_section_info">
            <p class="profile_section_info_name">{{ $user->name ?? '' }}</p>
            <p class="profile_section_info_role">{{ $user->email ?? '' }}</p>
        </div>
        <a href="{{ $userRoute }}" class="profile_section_link">
            <x-cms::i icon="fluent:open-12-regular" class="profile_section_link_icon" width="22" height="22" />
        </a>
    </div>
</aside>