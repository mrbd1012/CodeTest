<!-- Sidebar.vue -->
<template>
	<ul class="sidebar navbar-nav">
		<li class="nav-item">
            <router-link to="/home/categories" class="nav-link" exact>
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Categories</span>
            </router-link>
        </li>
        <li class="nav-item">
            <router-link to="/home/products" class="nav-link" exact>
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Products</span>
            </router-link>
        </li>
	</ul>
</template>
