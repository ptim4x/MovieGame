import React from "react";

/**
 * Picture display component
 */
const Picture = (props) => (
  <div className="col-md-4 px-0">
    <img
      className="rounded img-fluid"
      src={
        props.data ? props.data.img : "https://via.placeholder.com/400x500.png"
      }
      alt={props.data ? props.data.title : ""}
      title={props.data ? props.data.title : ""}
    />
  </div>
);

export default Picture;
