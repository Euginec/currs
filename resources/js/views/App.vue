<template>
    <div>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <router-link class="navbar-brand" :to="{ name: 'main' }">Test Task</router-link>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <router-link class="nav-link" to="rates" v-if="isLoggedIn">Rates</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link" to="logout" v-if="isLoggedIn">Logout</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link" to="/login" v-if="!isLoggedIn">Login</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link" to="register" v-if="!isLoggedIn">Register</router-link>
                        </li>
                            <!-- <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest -->
                    </ul>
                </div>
            </div>
        </nav>

        <main class="container py-4">
            <router-view></router-view>
        </main>

    </div>
</template>

<script>
export default {
    computed: {
        isLoggedIn : function(){ return this.$store.getters.isLoggedIn}
    }
}
</script>
