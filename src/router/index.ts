import { createRouter, createWebHistory } from 'vue-router';
import Demo from '../views/GameView.vue';



const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: '/', name: 'home', component: Demo },
  ],
});


router.beforeEach((to, from, next) => {
  interface PreventNavigation {
    (message: string): void;
  }

  const preventNavigation: PreventNavigation = (message: string) => {
    const confirmExit: boolean = confirm(message);
    if (confirmExit) {
      next();
    } else {
      next(false); // Cancel navigation
    }
  };


  if (to.name === 'demo' && from.name === null) {
    preventNavigation(
      'Vous êtes sur le point de recommencer la partie. Votre score sera perdu. Voulez-vous continuer ?'
    );
  }


  else if (
    from.name === 'demo' &&
    (to.name !== 'rules-3' && to.name !== 'summary')
  ) {
    preventNavigation(
      'Vous êtes sur le point de quitter cette partie. Votre score sera perdu. Voulez-vous continuer ?'
    );
  }


  // else if (to.name === 'rules-3' || from.name === 'rules-3') {
  //   preventNavigation(
  //     'Vous ne pouvez pas revenir en arrière ou avancer à partir des règles. Voulez-vous continuer ?'
  //   );
  // }

  // Default behavior: Allow navigation
  else {
    next();
  }
});

export default router;
