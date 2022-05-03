<template>
  <Link :class="applyClasses()" :href="link">
    <slot />
  </Link>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";

export default {
  components: {
    Link,
  },
  props: {
    look: {
      type: String,
      default: "link",
    },
    class: {
      type: String,
      default: "",
    },
    link: {
      type: String,
      default: "#",
    },
  },
  methods: {
    applyClasses() {
      let applicableClass = "";
      if (this.look == "button") {
        applicableClass +=
          "inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150";
      }
      if (this.class != "") {
        applicableClass += " " + this.class;
      }
      return applicableClass;
    },
  },
};
</script>
