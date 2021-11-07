<template>
    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
        <!-- Dashboard header -->
        <dashboardHeader></dashboardHeader>
        <div class="app-main">
                <!-- dashboard sidebar -->
                <dashboardSidebar></dashboardSidebar>
                <div class="app-main__outer">
                    <div class="app-main__inner">
                        <router-view/>
                    </div>
                    <!-- dashboard footer -->
                    <dashboardFooter></dashboardFooter>
                </div>
            </div>
        </div>
</template>
