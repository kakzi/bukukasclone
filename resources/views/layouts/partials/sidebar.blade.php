<x-maz-sidebar :href="route('dashboard')" :logo="asset('images/logo/logo.png')">

    <!-- Add Sidebar Menu Items Here -->
    <x-maz-sidebar-item name="Dashboard" :link="route('dashboard')" icon="bi bi-grid-fill"></x-maz-sidebar-item>
    <x-maz-sidebar-item name="Kategori Bisnis" :link="route('category.index')" icon="bi bi-clipboard-check"></x-maz-sidebar-item>
    <x-maz-sidebar-item name="Metode Payment" :link="route('metode_payment.index')" icon="bi bi-bank"></x-maz-sidebar-item>
    <x-maz-sidebar-item name="Channel Toko" :link="route('channel.index')" icon="bi bi-cart-fill"></x-maz-sidebar-item>
    <x-maz-sidebar-item name="Kategori Cash Out" :link="route('cashout.index')" icon="bi bi-clipboard-data-fill"></x-maz-sidebar-item>
   
    
</x-maz-sidebar>