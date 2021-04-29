
const App = {
  data() {
    return {

      /**
       * @note
       * current active step (rating)
       */
      activeIndex: 0,

      /**
       * @note
       * if false, you can't click
       */
      isActive: true,

      steps: [
        {title: '★', text: 'Хреново, все плохо, все очень плохо...'},
        {title: '★★', text: 'Ну так себе... Было видно что не хотя делалось...'},
        {title: '★★★', text: 'Потянет. Не хорошо ни плохо...'},
        {title: '★★★★', text: 'Хорошо. Но можно было и получше, если постараться....'},
        {title: '★★★★★', text: 'Безукаризненно, просто экстаз, не к чему придраться. '},
      ]
    }
  },
  methods: {

    /**
     * @note
     * when we click-Re-vote for the next one
     */
    reset() {
      this.activeIndex = 0
      this.isActive = true
    },

    /**
     * @note
     * when we click the button-Apply vote
     */
    nextOfFinish() {
        this.isActive = false;
    },

    /**
     * @note
     * when we click on the circle with the rating number
     */
    setActive(idx) {
      if (this.isActive != false) {
        this.activeIndex = idx;
      }
    }
  },

  computed: {

    /**
     * @note
     * the current selected step-displays additional information
     */
    activeStep() {
      return this.steps[this.activeIndex]
    }
  }
}

Vue.createApp(App).mount('#app')