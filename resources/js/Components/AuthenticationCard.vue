<template>
    <div class="max-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0
                bg-auth bg-cover bg-center">
        <div class="min-h-screen skin">
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 shadow-md overflow-hidden sm:rounded-lg
                        auth-card-bg">
                <div>
                    <slot name="logo" />
                </div>
                <slot />
            </div>
        </div>
    </div>
</template>
