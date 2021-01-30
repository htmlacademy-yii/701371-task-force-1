/* jshint esversion: 6 */

class TaskErrorBlock {

  constructor() {
    this.initHeaderDOMElements();
    this.beginClickEvent();
  }

  initHeaderDOMElements() {
    this.errorBlock = document.getElementsByClassName('warning-item--error')[0];
    this.button = document.getElementsByClassName('button')[0];
    this.content = document.getElementsByClassName('warning-error')[0];
  }

  // **

  getVisibility() {
    this.errorBlock.style.visibility = (this.content.innerHTML == 'Ошибки заполнения формы')
      ? 'visible'
      : 'hidden';
  }

  // **

  beginClickEvent() {
    this.errorBlock.style.visibility = 'hidden';
    this.button.onclick = () => { this.getVisibility(); };
  }
}

new TaskErrorBlock();
