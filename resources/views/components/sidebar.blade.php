<style>
    .sidebar-active {
        width: 100vw
    }

    #sidebar {
        transition: 0.3s
    }

    nav a {
        transition: 0.2s
    }
</style>
<div class="flex flex-col bg-green-500 h-screen p-4 whitespace-[wrap] z-50" id="sidebar">
    <span class="">
        <h1 class="mt-2 mb-4 font-extrabold text-center text-xl">E-Commerce App</h1>
        <div class="flex mb-2 whitespace-nowrap">
            <img src="{{Auth::user()->photo_url}}" class="rounded-full w-12 h-12 self-center object-cover drop-shadow-sm" alt="">
            <h2 class="self-center text-ellipsis overflow-hidden ml-2 drop-shadow-sm" id="user-name">{{Auth::user()->name}}</h2>
        </div>
    </span>
    <nav class="flex flex-col gap-2 h-full shadow-[inset_0px_45px_10px_-50px] w-[calc(100%+2rem)] pt-5 pl-4 pr-2 self-center">
        <a href="{{ url('dashboard') }}" class="{{ (request()->is('dashboard')) ? 'bg-green-500' : 'bg-white'}} flex flex-row gap-2 rounded-xl p-2 shadow-md hover:ring-2 hover:ring-green-900">
            <x-heroicon-o-home class="w-5 h-auto"/> Home
        </a>
        <a href="{{ url('users') }}" class="{{ (request()->is('users')) ? 'bg-green-500' : 'bg-white'}} flex flex-row gap-2 rounded-xl p-2 shadow-md hover:ring-2 hover:ring-green-900">
            <x-heroicon-o-user-circle class="w-5 h-auto"/> Users
        </a>
        <a href="{{ url('chats') }}" class="{{ (request()->is('chats')) ? 'bg-green-500' : 'bg-white'}} flex flex-row gap-2 rounded-xl p-2 shadow-md hover:ring-2 hover:ring-green-900">
            <x-heroicon-o-user-circle class="w-5 h-auto"/> Chats
        </a>
        <form action="{{ url('logout') }}" class="flex flex-col gap-2 mt-auto self-center" method="POST">
            @csrf
            <x-heroicon-o-x-mark class="self-center w-8" id="sidebar-close"/>
            <x-heroicon-o-arrow-right class="self-center w-8" id="sidebar-open"/>
            <button type="submit" class="flex flex-row rounded-md gap-2 text-white p-2 bg-red-500 cursor-pointer" value="Logout">
                 <h2 id="logout-text">Logout</h2>   <x-heroicon-o-arrow-left-on-rectangle class="text-white w-5 h-auto mx-auto"/>
            </button>
        </form>
    </nav>
</div>
<script>
    sidebar = document.getElementById('sidebar')
    sidebarOpen = document.getElementById('sidebar-open')
    sidebarClose = document.getElementById('sidebar-close')
    sideButtons = document.querySelectorAll('nav a')
    userName = document.getElementById('user-name')
    logoutText = document.getElementById('logout-text')

    function open()
    {
        sidebar.classList.remove('w-[5rem]')
        sidebar.classList.add('w-screen')
        sidebarOpen.classList.add('hidden')
        sidebarClose.classList.remove('hidden')
        logoutText.classList.remove('hidden')
        sideButtons.forEach(element => {
            element.classList.remove('opacity-0')
        });
        
    }

    function close()
    {
        sidebar.classList.add('w-[5rem]')
        sidebar.classList.remove('w-screen')
        sidebarOpen.classList.remove('hidden')
        sidebarClose.classList.add('hidden')
        logoutText.classList.add('hidden')
        sideButtons.forEach(element => {
            element.classList.add('opacity-0')
        });
    }

   

    if(window.innerWidth < 640)
    {
        sideButtons.forEach(element => {
            element.classList.add('opacity-0')
        });
        sidebar.classList.add('w-[5rem]')
        sidebarClose.classList.add('hidden')
        sidebarOpen.addEventListener('click', open)
        sidebarClose.addEventListener('click', close)
        logoutText.classList.add('hidden')
    } else {
        sidebarOpen.classList.add('hidden')
        sidebarClose.classList.add('hidden')
        sidebar.classList.add('w-[300px]')
    }
    console.log(sidebarOpen)
</script>