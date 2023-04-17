<x-layouts.app title="Home">
    {{-- <x-slot:title>Home</x-slot> --}}
    <h1 class="text-lg text-gray-800 text-center py-1 font-semibold">VNODE IMPLEMENTATION</h1>
    <p class="text-md shadow-md py-2 px-1 border rounded mx-2 my-2 bg-blue-400 text-gray-100">Se requiere instalar la
        libería
        <a href="https://github.com/tiagolr/vnodes" target="_blank" class="underline font-semibold">vnodes</a> ademas
        de la liberia
        <a href="http://victorjs.org/" target="_blank" class="underline font-semibold">
            victor</a> y esta ultima debe ser alterada en caso de usar un build como
        Vite,<br> (exportando por defecto victor y removiendo su primera linea)
    </p>
    <sink-vue></sink-vue>
</x-layouts.app>
