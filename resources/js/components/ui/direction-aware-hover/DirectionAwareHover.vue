<template>
  <div
    ref="divRef"
    :class="containerClass"
  >
    <div class="relative size-full overflow-hidden">
      <div
        class="relative size-full bg-gray-50 transition-transform duration-300 dark:bg-black"
      >
        <img
          :src="imageUrl"
          alt="image"
          :class="imageClass"
        />
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted } from "vue";
import { cn } from "@/lib/utils";

interface Props {
  imageUrl: string;
  childrenClass?: string;
  imageClass?: string;
  class?: string;
}

const props = withDefaults(defineProps<Props>(), {
  childrenClass: undefined,
  imageClass: undefined,
  class: undefined,
});

const divRef = ref<HTMLDivElement | null>(null);

const containerClass = computed(() =>
  cn(
    "group/card relative overflow-hidden rounded-lg bg-transparent transition-all duration-300",
    // Mobile first responsive sizing
    "h-48 w-48", // Base mobile size
    "xs:h-56 xs:w-56", // Extra small screens
    "sm:h-64 sm:w-64", // Small screens
    "md:h-64 md:w-80", // Medium screens
    "lg:h-54 lg:w-96", // Large screens
    "xl:h-[23rem] xl:w-[28rem]", // Extra large screens
    // Mobile touch improvements
    "touch-manipulation",
    props.class,
  ),
);

const imageClass = computed(() =>
  cn(
    "w-full object-cover transition-transform duration-300",
    // Responsive scaling
    props.imageClass,
  ),
);

const childrenClass = computed(() =>
  cn(
    "absolute z-40 text-white transition-opacity duration-300",
    // Responsive positioning
    "bottom-2 left-2 text-sm", // Mobile
    "sm:bottom-3 sm:left-3 sm:text-base", // Small screens
    "md:bottom-4 md:left-4 md:text-lg", // Desktop
    props.childrenClass,
  ),
);
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

/* Enhanced mobile touch targets */
@media (max-width: 768px) {
  .group\/card {
    min-height: 44px; /* iOS minimum touch target */
    min-width: 44px;
  }
}

/* Smooth transitions for mobile */
@media (prefers-reduced-motion: reduce) {
  * {
    transition-duration: 0.1s !important;
  }
}
</style>
