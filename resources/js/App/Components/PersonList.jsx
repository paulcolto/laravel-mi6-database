import React from 'react';

export default class PersonList extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            loading: false,
            loaded: false,
            people: []
        }
    }

    componentDidMount() {
        fetch('/api/person', {
            headers: {
                'Accept':       'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            this.setState({
                people: data
            })
        });
    }

    render() {
        return (
            <>
                <h1>Person list</h1>
                
                {
                    this.state.people.map(person => (
                        <div className="person">{ person.name }</div>
                    ))
                }
            </>
        )
    }
}