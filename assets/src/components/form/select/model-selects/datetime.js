/**
 * Internal imports
 */
import ModelSelect from '../model-select';
import * as model from '../../../../data/model/datetime';

/**
 * External imports
 */
import { __ } from '@eventespresso/i18n';
import { Component } from '@wordpress/element';
import { default as EditorSelect, getEditorSelectProps } from './editor-select';
import { PropTypes } from 'prop-types';

/**
 * Select Component for the Datetime Model.
 */
export default class DatetimeSelect extends Component {
	state = {
		modelName: model.MODEL_NAME,
		queryData: {},
	};

	static defaultProps = {
		selectConfiguration: {
			loadingMessage: () => __( 'Retrieving Datetimes.', 'event_espresso' ),
			noOptionsMessage: () => __(
				'No Datetimes.',
				'event_espresso',
			),
			placeholder: __( 'Select Datetime...', 'event_espresso' ),
		},
		...model.defaultQueryData,
		getQueryString: model.getQueryString,
		selectLabel: __( 'Select Datetime', 'event_espresso' ),
		addAllOptionLabel: __( 'All Datetimes', 'event_espresso' ),
	};

	static propTypes = {
		...model.queryDataTypes,
		forEventId: PropTypes.number,
		selectedDatetimeId: PropTypes.oneOfType( [
			PropTypes.number,
			PropTypes.string,
		] ),
		onDatetimeSelect: PropTypes.func,
		selectLabel: PropTypes.string,
	};

	addEventIdToQueryData( forEventId ) {
		this.setState( {
			queryData: {
				...this.state.queryData,
				forEventId,
			},
		} );
	}

	componentDidMount() {
		this.setState( {
			queryData: { ...this.props.queryData },
		} );
		if ( this.props.forEventId > 0 ) {
			this.addEventIdToQueryData( this.props.forEventId );
		}
	}

	componentDidUpdate( prevProps ) {
		if ( prevProps.forEventId !== this.props.forEventId ) {
			this.addEventIdToQueryData( this.props.forEventId );
		}
	}

	render() {
		const { selectedDatetimeId, onDatetimeSelect } = this.props;
		const selectOpts = {
			selectConfiguration: {
				defaultValue: selectedDatetimeId,
				onChange: onDatetimeSelect,
				...this.props.selectConfiguration,
			},
		};
		const props = {
			...this.props,
			...selectOpts,
			...this.state,
		};
		return <ModelSelect { ...props } />;
	}
}

/**
 * DatetimeSelect Component wrapped in a BaseControl component.
 */
export class EditorDatetimeSelect extends Component {
	static defaultProps = {
		selectLabel: __( 'Select Datetime', 'event_espresso' ),
	};
	static propTypes = {
		selectLabel: PropTypes.string,
	};

	render() {
		const props = { ...this.props };
		props.modelName = model.MODEL_NAME;
		const { editorProps, selectProps } = getEditorSelectProps( props );
		return (
			<EditorSelect { ...editorProps } >
				<DatetimeSelect { ...selectProps } />
			</EditorSelect>
		);
	}
}
