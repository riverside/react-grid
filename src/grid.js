/**
 * React Grid Component v0.1.0
 *
 * Copyright 2014-2015, Dimitar Ivanov 
 *
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 */
 var Table = React.createClass({
    loadData: function () {
        $.ajax({
            url: this.props.url,
            data: {
                page: this.state.data.paginate.page,
                row_count: this.state.data.paginate.row_count,
                col_name: this.state.data.paginate.col_name,
                direction: this.state.data.paginate.direction
            },
            dataType: "json",
            success: function (data) {
                this.setState({paginate: data.paginate});
                this.setState({data: data});
            }.bind(this),
            error: function (xhr, status, err) {
                console.log(this.props.url, status, err.toString());
            }.bind(this)
        });
    },
    getInitialState: function () {
        return {
            data: {
                columns: [],
                items: [],
                paginate: {
                    page: 1,
                    pages: 1,
                    offset: 0,
                    row_count: 5,
                    total: 0,
                    col_name: "Name",
                    direction: "asc"
                }
            }
        };
    },
    componentDidMount: function () {
        this.loadData();
    },
    getFirst: function () {
        this.setState({paginate: $.extend(this.state.paginate, {
            page: 1
        })});
        this.loadData.call(this);
    },
    getPrev: function () {
        this.setState({paginate: $.extend(this.state.paginate, {
            page: this.state.paginate.page - 1
        })});
        this.loadData.call(this);
    },
    getNext: function () {
        this.setState({paginate: $.extend(this.state.paginate, {
            page: this.state.paginate.page + 1
        })});
        this.loadData.call(this);
    },
    getLast: function () {
        this.setState({paginate: $.extend(this.state.paginate, {
            page: this.state.paginate.pages
        })});
        this.loadData.call(this);
    },
    changeRowCount: function (e) {
        var el = e.target;
        this.setState({paginate: $.extend(this.state.paginate, {
            row_count: el.options[el.selectedIndex].value
        })});
        this.loadData.call(this);
    },
    sortData: function (e) {
        e.preventDefault();
        var el = e.target,
            col_name = el.getAttribute("data-column"),
            direction = el.getAttribute("data-direction");
        this.setState({paginate: $.extend(this.state.paginate, {
            col_name: col_name,
            direction: direction
        })});
        this.loadData.call(this);
    },
    render: function () {
        return (
            <table className="r-table">
                <Head data={this.state.data} onSort={this.sortData} />
                <Body data={this.state.data} />
                <Foot data={this.state.data} onFirst={this.getFirst} onPrev={this.getPrev} onNext={this.getNext} onLast={this.getLast} onChange={this.changeRowCount} onRefresh={this.loadData}/>
            </table>
        );
    }
});

var Head = React.createClass({
    render: function () {
        var that = this;
        return (
            <thead>
                <tr>
                {this.props.data.columns.map(function (column, i) {
                    return <HeadCell key={i} column={column} direction={that.props.data.paginate.direction} onSort={that.props.onSort} />
                })}
                </tr>
            </thead>
        );
    }
});

var Foot = React.createClass({
    render: function () {
        return (
            <tfoot>
                <tr>
                    <td colSpan={this.props.data.columns.length}>
                        <div className="r-paginate">
                            <Button text="&lt;&lt; First" onClick={this.props.onFirst} disabled={this.props.data.paginate.page===1} />
                            <Button text="&lt; Prev" onClick={this.props.onPrev} disabled={this.props.data.paginate.page===1} />
                            <Button text="Next &gt;" onClick={this.props.onNext} disabled={this.props.data.paginate.page===this.props.data.paginate.pages} />
                            <Button text="Last &gt;&gt;" onClick={this.props.onLast} disabled={this.props.data.paginate.page===this.props.data.paginate.pages} />
                            <Button text="Refresh" onClick={this.props.onRefresh} disabled={false} />
                        </div>
                        <div className="r-rowcount">
                        <select onChange={this.props.onChange} name="row_count">
                            <Option value="5" />
                            <Option value="10" />
                        </select> rows per page
                        </div>
                        <div className="r-stats">
                            <span className="">Page {this.props.data.paginate.page} of {this.props.data.paginate.pages}</span>
                        </div>
                    </td>
                </tr>
            </tfoot>
        );
    }
});

var Button = React.createClass({
    render: function () {
        return (
            <button type="button" onClick={this.props.onClick} disabled={this.props.disabled}>{this.props.text}</button>
        );
    }
});

var Option = React.createClass({
    render: function () {
        return (
            <option value={this.props.value}>{this.props.value}</option>
        );
    }
});

var Body = React.createClass({
    render: function () {
        var that = this;
        return (
            <tbody>
            {this.props.data.items.map(function(item, i) {
                return <Row key={i} item={item} columns={that.props.data.columns} />
            })}
            </tbody>
        );
    }
});

var Row = React.createClass({
    render: function () {
        var that = this;
        return (
            <tr>
            {this.props.columns.map(function (column, i) {
                return <Cell key={i} column={column} value={that.props.item[column.key]} />
            })}
            </tr>
        );
    }
});

var HeadCell = React.createClass({
    render: function () {
        return (
            <th><a href="#" data-column={this.props.column.key} data-direction={this.props.direction==="desc"?"asc":"desc"} role="button" tabIndex="0" onClick={this.props.onSort}>{this.props.column.label}</a></th>
        );
    }
});

var Cell = React.createClass({
    render: function () {
        return (
            <td>{Draw(this.props.column, this.props.value)}</td>
        );
    }
});

var Draw = function (column, value) {
    switch (column.type) {
        case 'Number':
            return value;
            break;
        case 'String':
            return value;
            break;
        case 'Image':
            return React.createElement('img', {src: value}, null);
            break;
    }
}

React.render(
    <Table url="ajax.php?action=grid" />,
    document.getElementById("grid")
);