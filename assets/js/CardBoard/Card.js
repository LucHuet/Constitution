import React, {Component} from 'react';
import PropTypes from 'prop-types';

export default class Card extends Component {

  constructor(props){
    super(props);
    //on descructure les props pour en récuperer les variables

  }



  handleDeleteClick (event, acteurId){
    //évite le comportement normal du boutton
    //exemple évite que le submit soumette la page.
    event.preventDefault();

    this.onDeleteActeur(acteurId);
  }

  render(){

    const {
      highlightedRowId,
      onRowClick,
      acteurs,
      onDeleteActeur,
      isLoaded,
      isSavingNewActeur,
      //sorter

    } = this.props;

    if(!isLoaded){
      return(
            <div>Loading...</div>
      )
    }

    return(
      <div>
        { /*
        pour chaque acteur restant on le met dans le tableau
      */ }
        <div id="sort1" className="ui cards" data-sortable=".card">
        {acteurs.map((acteur, index) => (
          <div
            className="card"
            key={acteur.id}
            onClick={()=> onRowClick(acteur.id)}
            data-position={index - 1}
            data-id={index}
            style={{
                position: "relative",
                top: "0px",
                left: "0px",
                transitionDuration: null,
            }}
          >
            <div className="content">
                {acteur.nom} -
                {acteur.nombreIndividus} -
                <a href="#" onClick={(event => handleDeleteClick(event, acteur.id))}>
                    <span className="fa fa-trash"></span>
                </a>
            </div>
          </div>
          )
        )}
        </div>
        {isSavingNewActeur && (
          <div id="sort1" className="ui cards" data-sortable=".card">
            En ajout ...
          </div>
        )}
      </div>

    );
  }
}

//on défini les types des props
Card.propTypes = {
  highlightedRowId: PropTypes.any,
  onRowClick: PropTypes.func.isRequired,
  onDeleteActeur: PropTypes.func.isRequired,
  acteurs: PropTypes.array.isRequired,
  isLoaded: PropTypes.bool.isRequired,
  isSavingNewActeur: PropTypes.bool.isRequired,
  isPageOnLoad: PropTypes.bool,
};
