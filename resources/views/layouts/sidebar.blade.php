<aside>
    <div class="nav-section">
        <!-- Логотип -->
        <div class="nav-section-logo">
            <h3 class="text-secondary">LindenCMS</h3>
        </div>
        <!-- Навигация -->
        <nav>
            <div class="group">Dashboard</div>
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <x-cms::i icon="boxicons:dashboard-filled" width="18" height="18" />
                <span>Dashboard</span>
            </a>
            @foreach (config('lindencms.navigation') as $group => $nodes)
                @if ($group)
                    <div class="group">{{ $group }}</div>
                @endif
                @foreach ($nodes as $nodeClass)
                    @php
                        $node = $nodeClass::make();
                    @endphp

                    {!! $node->context('html.sidebar-nav-link') !!}
                @endforeach
            @endforeach
        </nav>
    </div>

    @php
        $user = LindenCMS\Cms\Nodes\User::read(auth()->id());
        $userRoute = route('nodes.edit', [
            'code' => $user->code(),
            'id' => $user->id->get(),
        ]);
    @endphp
    <!-- Блок пользователя -->
    <div class="profile-section">
        <div class="profile-section-avatar">
            <img src="{{ $user->avatar->image()?->previewUrl() }}"/>
        </div>
        <div class="profile-section-info">
            <p class="profile-section-info-name">{{ $user->name ?? '' }}</p>
            <p class="profile-section-info-role">{{ $user->email ?? '' }}</p>
            <!-- <p class="profile-section-info-role">administrator</p> -->
        </div>
        <a href="{{ $userRoute }}" class="profile-section-link">
            <x-cms::i icon="fluent:open-12-regular" class="profile-section-link-icon" width="22" height="22" />
        </a>
    </div>
</aside>