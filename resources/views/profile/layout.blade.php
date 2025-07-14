<x-app-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">My Profile & CV</h1>
        <p class="text-gray-500">Keep your professional information up-to-date to stand out.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        {{-- 1. Profile Navigation Sidebar (Left Column) --}}
        <div class="lg:col-span-1">
            <div class="bg-white p-4 rounded-xl shadow-soft">
                <nav class="space-y-1">
    {{-- Back to Dashboard Link --}}
    <x-sidebar-link :href="route('dashboard')">
        <i class="fas fa-arrow-left mr-3 w-5 text-center"></i>
        Back to Dashboard
    </x-sidebar-link>

    <div class="pt-4 mt-4 border-t border-gray-200">
        <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Manage My Profile</p>

        <x-sidebar-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
            <i class="fas fa-user-circle mr-3 w-5 text-center"></i>
            Personal Information
        </x-sidebar-link>

        <x-sidebar-link :href="route('images.index')" :active="request()->routeIs('images.index')">
            <i class="fas fa-camera mr-3 w-5 text-center"></i>
            Picture & Signature
        </x-sidebar-link>

        <x-sidebar-link :href="route('education.index')" :active="request()->routeIs('education.*')">
            <i class="fas fa-graduation-cap mr-3 w-5 text-center"></i>
            Education
        </x-sidebar-link>

        <x-sidebar-link :href="route('experience.index')" :active="request()->routeIs('experience.*')">
            <i class="fas fa-briefcase mr-3 w-5 text-center"></i>
            Work Experience
        </x-sidebar-link>

        <x-sidebar-link :href="route('training.index')" :active="request()->routeIs('training.*')">
            <i class="fas fa-certificate mr-3 w-5 text-center"></i>
            Trainings
        </x-sidebar-link>

        <x-sidebar-link :href="route('language.index')" :active="request()->routeIs('language.*')">
            <i class="fas fa-language mr-3 w-5 text-center"></i>
            Languages
        </x-sidebar-link>

        <x-sidebar-link :href="route('publication.index')" :active="request()->routeIs('publication.*')">
            <i class="fas fa-book-open mr-3 w-5 text-center"></i>
            Publications
        </x-sidebar-link>

        {{-- NEW LINK FOR AWARDS --}}
        <x-sidebar-link :href="route('award.index')" :active="request()->routeIs('award.*')">
            <i class="fas fa-award mr-3 w-5 text-center"></i>
            Awards
        </x-sidebar-link>
        {{-- END NEW LINK --}}

        <x-sidebar-link :href="route('referee.index')" :active="request()->routeIs('referee.*')">
            <i class="fas fa-users mr-3 w-5 text-center"></i>
            Referees
        </x-sidebar-link>

        <x-sidebar-link :href="route('document.index')" :active="request()->routeIs('document.*')">
            <i class="fas fa-file-alt mr-3 w-5 text-center"></i>
            My Documents
        </x-sidebar-link>

    </div>
</nav>
            </div>
        </div>

        {{-- 2. Main Content Slot (Right Column) --}}
        <div class="lg:col-span-3">
            {{ $slot }}
        </div>
    </div>
</x-app-layout>
