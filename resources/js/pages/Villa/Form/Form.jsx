import React from 'react';
import GalleryCard from './GalleryCard'
import Content from './Content'
import Facility from './Facility'
import HighlightFacility from './HighlightFacility'
import { useParams } from 'react-router-dom';

function Form(props) {
    const { id } = useParams()
    return (
        <div className="container-fluid py-4">
            <div className="row">
                <div className="col-12">
                    <Content /> 
                    { id > 0 && <GalleryCard />}
                    { id > 0 && <HighlightFacility /> }
                    { id > 0 && <Facility /> }
                    </div>
            </div>
        </div>
    );
}

export default Form;