<template>
  <div>
    <div :class="'sidebar_point' + $store.state.activeSidebar">
      <div class="logo_content">
        <router-link class="logo" to="/">
          <i class="bx bx-stopwatch"></i>
          <div class="logo_name">Points</div>
        </router-link>
        <div class="menu_point" @click="sidebar()">
          <i class="bx bx-menu" id="menu"></i>
          <i class="bx bx-menu-alt-left" id="menu-alt-left"></i>
        </div>
      </div>
      <ul class="nav_list">
        <li class="list">
          <router-link to="painel">
            <b></b>
            <b></b>
            <i class="bx bx-grid-alt"></i>
            <span class="links_name">Painel</span>
            <div class="b2"></div>
            <span class="tooltip">Painel</span>
          </router-link>
        </li>
        <li class="list">
          <router-link to="empresa">
            <b></b>
            <b></b>
            <i class="bx bx-grid-alt"></i>
            <span class="links_name">Empresa</span>
            <div class="b2"></div>
            <span class="tooltip">Empresa</span>
          </router-link>
        </li>
        <li class="list">
          <router-link to="departamento">
            <b></b>
            <b></b>
            <i class="bx bx-grid-alt"></i>
            <span class="links_name">Departamento</span>
            <div class="b2"></div>
            <span class="tooltip">Departamento</span>
          </router-link>
        </li>
        <li class="list">
          <router-link to="equipe">
            <b></b>
            <b></b>
            <i class="bx bx-grid-alt"></i>
            <span class="links_name">Equipe</span>
            <div class="b2"></div>
            <span class="tooltip">Equipe</span>
          </router-link>
        </li>
        <li class="list">
          <router-link to="controle-ponto">
            <b></b>
            <b></b>
            <i class="bx bx-grid-alt"></i>
            <span class="links_name">Controle de Ponto</span>
            <div class="b2"></div>
            <span class="tooltip">Controle de Ponto</span>
          </router-link>
        </li>
        <li class="list">
          <router-link to="turno">
            <b></b>
            <b></b>
            <i class="bx bx-grid-alt"></i>
            <span class="links_name">Turno</span>
            <div class="b2"></div>
            <span class="tooltip">Turno</span>
          </router-link>
        </li>
      </ul>
    </div>

    <div class="home_content d-flex flex-column">
      <div id="content-flex">
        <nav
          class="
            navbar navbar-expand navbar-light
            bg-gradient-dark
            topbar
            mb-4
            static-top
          "
        >
          <div class="mr-3 menu_sidebarY" @click="sidebar()">
            <i class="bx bx-menu"></i>
          </div>
          <router-link to="/" class="logo">
            <i class="bx bx-stopwatch mr-1"></i>
            <div class="logo_name">Points</div>
          </router-link>

          <ul class="navbar-nav ml-auto">
            <li v-if="isAuth" class="nav-item dropdown no-arrow">
              <a
                class="nav-link dropdown-toggle"
                href="#"
                id="userDropdown"
                role="button"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
              >
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"
                  >Marcos Young</span
                >
                <!-- <img class="img-profile rounded-circle" src="{{ asset('img/undraw_profile.svg') }}"> -->
                <img class="img-profile rounded-circle" src="#" />
              </a>
              <div
                class="
                  dropdown-menu dropdown-menu-right
                  shadow
                  animated--grow-in
                "
                aria-labelledby="userDropdown"
              >
                <a class="dropdown-item" href="#">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Settings
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                  Active Log
                </a>
                <div class="dropdown-divider"></div>
                <a
                  class="dropdown-item"
                  href="#"
                  data-toggle="modal"
                  data-target="#logoutModal"
                >
                  <i
                    class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"
                  ></i>
                  Logout
                </a>
              </div>
            </li>
            <li v-else class="nav-item no-arrow">
              <!-- <a class="nav-link " href="{{ route('login') }}" role="button"> -->
              <router-link class="nav-link" to="calendar">
                <!-- <a class="nav-link " href="#" role="button"> -->
                <!-- <img class="img-profile rounded-circle" src="{{ asset('img/undraw_profile_1.svg') }}"> -->
                <img class="img-profile rounded-circle" src="#" />
                <!-- </a> -->
              </router-link>
            </li>
          </ul>
        </nav>

        <div class="container-fluid">
            <div class="header_iner row d-flex justify-content-between align-items-center">
                <div class="page_title_left col-md-6">
                    <h5 class="text-gray-700 font-weight-bold">Olá Marcos, seja bem vindo!</h5>
                    <ol class="breadcrumb page_bradcam mb-0">
                        <li class="breadcrumb-item text-xs"><router-link to="/">Home</router-link></li>
                        <li class="breadcrumb-item text-xs active">Painel</li>
                    </ol>
                </div>

                <div class="page_title_right col-md-6 d-flex justify-content-between align-items-center">
                    <div class="page_date_button d-flex align-items-center">
                        <i class="far fa-calendar-alt mr-2 fa-2x"></i>
                        Quinta-feira, 26 de agosto de 2021.
                    </div>
                </div>
            </div>

          <router-view></router-view>
        </div>
      </div>

      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Points Controller 2021</span>
          </div>
        </div>
      </footer>
    </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div
      class="modal fade"
      id="logoutModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button
              class="close"
              type="button"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            Select "Logout" below if you are ready to end your current session.
          </div>
          <div class="modal-footer">
            <button
              class="btn btn-secondary"
              type="button"
              data-dismiss="modal"
            >
              Cancel
            </button>
            <a class="btn btn-primary" href="login.html">Logout</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "TESTE",
  mounted() {
    if (this.checkCookie("sidebar=active")) {
      this.$store.state.activeSidebar = " active";
    }
    console.log("Layout Montado");
  },
  data() {
    return {};
  },
  computed: {},
  methods: {
    sidebar() {
      if (this.$store.state.activeSidebar) {
        this.$store.state.activeSidebar = "";
        document.cookie =
          "sidebar=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
      } else {
        this.$store.state.activeSidebar = " active";
        document.cookie = "sidebar=active";
      }
    },
    checkCookie(cookie) {
      if (document.cookie.split(";").some((item) => item.includes(cookie))) {
        return true;
      }
    },
  },
  props: ["is-auth"],
};
</script>
