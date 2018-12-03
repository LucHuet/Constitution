import interact from 'interactjs';
import _ from 'lodash';

export default class Sortable {

  constructor(element, scrollable){
    var self = this; //plus besoin en react
    if(scrollable == null){
      scrollable = document.body;
    }
    this.scrollable = scrollable;// récupéré dans App et transmis en dessous
    this.element = element;// récupéré dans App et transmis en dessous
    //dans componentDidMount car on le récupère des le début :
    this.items = this.element.querySelectorAll(this.element.getAttribute('data-sortable')); //ou e.dataset.sortable
    //on met les cartes à leur position initiale
    this.setPositions();
    window.addEventListener('resize', _.debounce(function(){
      self.setPositions();
    }, 200));

    //on effectu les actions de "dragg"
    interact(this.element.dataset.sortable, {
      context: this.element
    }).draggable({
      inertia: false,
      manualStart: false,
      autoScroll: {
        container: scrollable,
        margin: 250,
        speed: 600
      },
      onmove: _.throttle(function (e){
        self.move(e)
      }, 16, {trailing: false})
    }).on('dragstart', function(e){
      var r = e.target.getBoundingClientRect();
      e.target.classList.add('is-dragged');
      self.startPosition = e.target.dataset.position;
      self.offset = {
        x: e.clientX - r.left,
        y: e.clientY - r.top
      };
      self.scrollTopStart = self.scrollable.scrollTop;
    }).on('dragend', function(e){
      e.target.classList.remove('is-dragged');
      self.moveItem(e.target, e.target.dataset.position);
    });
  }

  setPositions(ajoutSuppressionItem = false){
    var self = this;
    this.items = this.element.querySelectorAll(this.element.getAttribute('data-sortable'));
    //récupère un rectangle de la taille d'une carte
    var rect = this.items[0].getBoundingClientRect();
    //récupère la longueur et largueur du rectangle
    this.item_width = Math.floor(rect.width);
    this.item_height = Math.floor(rect.width / 1.6);
    //récupère le nombre de colonne en fonction de la taille des rectangles
    // ! dépend de element
    this.cols = Math.floor(this.element.offsetWidth / this.item_width);
    //on détermine la taille de element afin de pouvoir mettre des chose dessous
    // ! dépend de element
    this.element.style.height = (this.item_height * Math.ceil(this.items.length / this.cols)) + "px";
    //on change le style des cartes pour les rendre absolute
    for(var i = 0; i< this.items.length; i++) {
      var item = this.items[i];
      item.style.position = "absolute";
      item.style.top = "0px";
      item.style.left = "0px";
      item.style.height = this.item_height;
      item.style.transitionDuration = ajoutSuppressionItem ? null : "0s";
      var position = item.dataset.position;
      this.moveItem(item, position);
    }
    //on réinitialise la transition pour un effet visuel
    window.setTimeout(function(){
      for(var i = 0; i< self.items.length; i++) {
        var item = self.items[i];
        item.style.transitionDuration = null;
      }
    }, 100);
  }

  move(e){
    var p = this.getXY(this.startPosition);
    var x = p.x + e.clientX - e.clientX0;
    var y = p.y + e.clientY - e.clientY0 + this.scrollable.scrollTop - this.scrollTopStart;
    e.target.style.transform = "translate3D(" + x + "px, " + y + "px, 0)";
    var oldPosition = e.target.dataset.position;
    var newPosition = this.guessPosition(x + this.offset.x, y + this.offset.y);
    if(oldPosition != newPosition){
      this.swap(oldPosition, newPosition);
      e.target.dataset.position = newPosition;
    }
    this.guessPosition(x, y);
  }

  getXY(position){
    var x = this.item_width * (position % this.cols);
    var y = this.item_height * Math.floor(position / this.cols);
      return {
        x: x,
        y: y
      };
  }

  guessPosition(x, y){
    var col = Math.floor(x / this.item_width);
    if(col >= this.cols){
      col = this.cols - 1;
    }
    if(col <= 0){
      col = 0;
    }

    var row = Math.floor(y / this.item_height);
    if(row < 0){
      row = 0;
    }

    var position = col + row * this.cols;
    if(position >= this.items.length){
      return this.items.length -1;
    }
    return position;
  }

  swap (start, end){
      for(var i = 0; i< this.items.length; i++) {
        var item = this.items[i];
        if(!item.classList.contains('is-dragged'))
        {
          var position = parseInt(item.dataset.position, 10);
          if(position >= end && position < start && end < start){
            this.moveItem(item, position + 1);
          } else if(position <= end && position > start && start < end){
            this.moveItem(item, position -1);
          }
        }

      }
  }

  moveItem (item, position){
    var p = this.getXY(position);
    item.style.transform = "translate3D(" + p.x + "px, " + p.y + "px, 0)";
    item.dataset.position = position;
  }
}
