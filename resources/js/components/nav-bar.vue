
<script>
import i18n from "../i18n";
import simplebar from "simplebar-vue";

/**
 * Nav-bar Component
 */
export default {
  data() {
    return {
      languages: [
        {
          flag: "/images/flags/us.jpg",
          language: "en",
          title: "English",
        },
        {
          flag: "/images/flags/french.jpg",
          language: "fr",
          title: "French",
        },
        {
          flag: "/images/flags/spain.jpg",
          language: "es",
          title: "Spanish",
        },
        {
          flag: "/images/flags/chaina.png",
          language: "zh",
          title: "Chinese",
        },
        {
          flag: "/images/flags/arabic.png",
          language: "ar",
          title: "Arabic",
        },
      ],
      lan: i18n.locale,
      text: null,
      flag: null,
      value: null,
    };
  },
  components: { simplebar },
  mounted() {
    this.value = this.languages.find((x) => x.language === i18n.locale);
    this.text = this.value.title;
    this.flag = this.value.flag;
  },
  methods: {
    toggleMenu() {
      this.$parent.toggleMenu();
    },
    toggleRightSidebar() {
      this.$parent.toggleRightSidebar();
    },
    initFullScreen() {
      document.body.classList.toggle("fullscreen-enable");
      if (
        !document.fullscreenElement &&
        /* alternative standard method */ !document.mozFullScreenElement &&
        !document.webkitFullscreenElement
      ) {
        // current working methods
        if (document.documentElement.requestFullscreen) {
          document.documentElement.requestFullscreen();
        } else if (document.documentElement.mozRequestFullScreen) {
          document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullscreen) {
          document.documentElement.webkitRequestFullscreen(
            Element.ALLOW_KEYBOARD_INPUT
          );
        }
      } else {
        if (document.cancelFullScreen) {
          document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
          document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
          document.webkitCancelFullScreen();
        }
      }
    },
    setLanguage(locale, country, flag) {
      this.lan = locale;
      this.text = country;
      this.flag = flag;
      i18n.locale = locale;
      localStorage.setItem("locale", locale);
    },
  },
};
</script>

<template>
  <header id="page-topbar">
    <div class="navbar-header">
      <div class="d-flex">
        <!-- LOGO -->
        <div class="navbar-brand-box">
          <a href="/" class="logo logo-dark">
            <span class="logo-sm">
              <img src="/images/logo.svg" alt height="22" />
            </span>
            <span class="logo-lg">
              <img src="/images/logo-dark.png" alt height="17" />
            </span>
          </a>

          <a href="/" class="logo logo-light">
            <span class="logo-sm">
              <img src="/images/logo-light.svg" alt height="22" />
            </span>
            <span class="logo-lg">
              <img src="/images/logo-light.png" alt height="19" />
            </span>
          </a>
        </div>

        <button
          id="vertical-menu-btn"
          type="button"
          class="btn btn-sm px-3 font-size-16 header-item"
          @click="toggleMenu"
        >
          <i class="fa fa-fw fa-bars"></i>
        </button>
      </div>

      <div class="d-flex">

        <b-dropdown
          class="d-none d-lg-inline-block noti-icon"
          menu-class="dropdown-menu-lg"
          right
          toggle-class="header-item"
          variant="black"
        >
          <template v-slot:button-content>
            <i class="bx bx-customize"></i>
          </template>

          <div class="px-lg-2">
            <div class="row no-gutters">
              <div class="col">
                <a class="dropdown-icon-item" href="javascript: void(0);">
                  <img src="/images/brands/github.png" alt="Github" />
                  <span>{{ $t('navbar.dropdown.site.list.github') }}</span>
                </a>
              </div>
              <div class="col">
                <a class="dropdown-icon-item" href="javascript: void(0);">
                  <img src="/images/brands/bitbucket.png" alt="bitbucket" />
                  <span>{{ $t('navbar.dropdown.site.list.github') }}</span>
                </a>
              </div>
              <div class="col">
                <a class="dropdown-icon-item" href="javascript: void(0);">
                  <img src="/images/brands/dribbble.png" alt="dribbble" />
                  <span>{{ $t('navbar.dropdown.site.list.dribbble') }}</span>
                </a>
              </div>
            </div>

            <div class="row no-gutters">
              <div class="col">
                <a class="dropdown-icon-item" href="javascript: void(0);">
                  <img src="/images/brands/dropbox.png" alt="dropbox" />
                  <span>{{ $t('navbar.dropdown.site.list.dropbox') }}</span>
                </a>
              </div>
              <div class="col">
                <a class="dropdown-icon-item" href="javascript: void(0);">
                  <img src="/images/brands/mail_chimp.png" alt="mail_chimp" />
                  <span>{{ $t('navbar.dropdown.site.list.mailchimp') }}</span>
                </a>
              </div>
              <div class="col">
                <a class="dropdown-icon-item" href="javascript: void(0);">
                  <img src="/images/brands/slack.png" alt="slack" />
                  <span>{{ $t('navbar.dropdown.site.list.slack') }}</span>
                </a>
              </div>
            </div>
          </div>
        </b-dropdown>

        <div class="dropdown d-none d-lg-inline-block ml-1">
          <button type="button" class="btn header-item noti-icon" @click="initFullScreen">
            <i class="bx bx-fullscreen"></i>
          </button>
        </div>

        <b-dropdown
          right
          menu-class="dropdown-menu-lg p-0"
          toggle-class="header-item noti-icon"
          variant="black"
        >
          <template v-slot:button-content>
            <i class="bx bx-bell bx-tada"></i>
            <span
              class="badge badge-danger badge-pill"
            >{{ $t('navbar.dropdown.notification.badge')}}</span>
          </template>

          <div class="p-3">
            <div class="row align-items-center">
              <div class="col">
                <h6 class="m-0">{{ $t('navbar.dropdown.notification.text')}}</h6>
              </div>
              <div class="col-auto">
                <a href="#" class="small">{{ $t('navbar.dropdown.notification.subtext')}}</a>
              </div>
            </div>
          </div>
          <simplebar style="max-height: 230px;">
            <a href="javascript: void(0);" class="text-reset notification-item">
              <div class="media">
                <div class="avatar-xs mr-3">
                  <span class="avatar-title bg-primary rounded-circle font-size-16">
                    <i class="bx bx-cart"></i>
                  </span>
                </div>
                <div class="media-body">
                  <h6 class="mt-0 mb-1">{{ $t('navbar.dropdown.notification.order.title')}}</h6>
                  <div class="font-size-12 text-muted">
                    <p class="mb-1">{{ $t('navbar.dropdown.notification.order.text')}}</p>
                    <p class="mb-0">
                      <i class="mdi mdi-clock-outline"></i>
                      {{ $t('navbar.dropdown.notification.order.time')}}
                    </p>
                  </div>
                </div>
              </div>
            </a>
            <a href="javascript: void(0);" class="text-reset notification-item">
              <div class="media">
                <img
                  src="/images/users/avatar-3.jpg"
                  class="mr-3 rounded-circle avatar-xs"
                  alt="user-pic"
                />
                <div class="media-body">
                  <h6 class="mt-0 mb-1">{{ $t('navbar.dropdown.notification.james.title')}}</h6>
                  <div class="font-size-12 text-muted">
                    <p class="mb-1">{{ $t('navbar.dropdown.notification.james.text')}}</p>
                    <p class="mb-0">
                      <i class="mdi mdi-clock-outline"></i>
                      {{ $t('navbar.dropdown.notification.james.time')}}
                    </p>
                  </div>
                </div>
              </div>
            </a>
            <a href="javascript: void(0);" class="text-reset notification-item">
              <div class="media">
                <div class="avatar-xs mr-3">
                  <span class="avatar-title bg-success rounded-circle font-size-16">
                    <i class="bx bx-badge-check"></i>
                  </span>
                </div>
                <div class="media-body">
                  <h6 class="mt-0 mb-1">{{ $t('navbar.dropdown.notification.item.title')}}</h6>
                  <div class="font-size-12 text-muted">
                    <p class="mb-1">{{ $t('navbar.dropdown.notification.item.text')}}</p>
                    <p class="mb-0">
                      <i class="mdi mdi-clock-outline"></i>
                      {{ $t('navbar.dropdown.notification.item.time')}}
                    </p>
                  </div>
                </div>
              </div>
            </a>
            <a href="javascript: void(0);" class="text-reset notification-item">
              <div class="media">
                <img
                  src="/images/users/avatar-4.jpg"
                  class="mr-3 rounded-circle avatar-xs"
                  alt="user-pic"
                />
                <div class="media-body">
                  <h6 class="mt-0 mb-1">{{ $t('navbar.dropdown.notification.salena.title')}}</h6>
                  <div class="font-size-12 text-muted">
                    <p class="mb-1">{{ $t('navbar.dropdown.notification.salena.text')}}</p>
                    <p class="mb-0">
                      <i class="mdi mdi-clock-outline"></i>
                      {{ $t('navbar.dropdown.notification.salena.time')}}
                    </p>
                  </div>
                </div>
              </div>
            </a>
          </simplebar>
          <div class="p-2 border-top">
            <a class="btn btn-sm btn-light btn-block text-center" href="javascript:void(0)">
              <i class="mdi mdi-arrow-down-circle mr-1"></i>
              {{ $t('navbar.dropdown.notification.button')}}
            </a>
          </div>
        </b-dropdown>

        <b-dropdown right variant="black" toggle-class="header-item">
          <template v-slot:button-content>
            <img
              class="rounded-circle header-profile-user"
              src="/images/users/avatar-1.jpg"
              alt="Header Avatar"
            />
            <span class="d-none d-xl-inline-block ml-1">{{ $page.props.user.name }}</span>
            <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
          </template>
          <!-- item-->
          <b-dropdown-item>
            <a href="/contacts/profile">
              <i class="bx bx-user font-size-16 align-middle mr-1"></i>
              {{ $t('navbar.dropdown.henry.list.profile') }}
            </a>
          </b-dropdown-item>
          <b-dropdown-item href="javascript: void(0);">
            <i class="bx bx-wallet font-size-16 align-middle mr-1"></i>
            {{ $t('navbar.dropdown.henry.list.mywallet') }}
          </b-dropdown-item>
          <b-dropdown-item class="d-block" href="javascript: void(0);">
            <span class="badge badge-success float-right">11</span>
            <i class="bx bx-wrench font-size-16 align-middle mr-1"></i>
            {{ $t('navbar.dropdown.henry.list.settings') }}
          </b-dropdown-item>
          <b-dropdown-item href="javascript: void(0);">
            <i class="bx bx-lock-open font-size-16 align-middle mr-1"></i>
            {{ $t('navbar.dropdown.henry.list.lockscreen') }}
          </b-dropdown-item>
          <b-dropdown-divider></b-dropdown-divider>
          
          <inertia-link method="post" class="dropdown-item text-danger" :href="route('canvas.logout')" as="button">
                <i class="bx bx-power-off font-size-16 align-middle mr-1 text-danger"></i>
                {{ $t('navbar.dropdown.henry.list.logout') }}
          </inertia-link>
        </b-dropdown>

        <div class="dropdown d-inline-block">
          <button
            type="button"
            class="btn header-item noti-icon right-bar-toggle toggle-right"
            @click="toggleRightSidebar"
          >
            <i class="bx bx-cog bx-spin toggle-right"></i>
          </button>
        </div>
      </div>
    </div>
  </header>
</template>
