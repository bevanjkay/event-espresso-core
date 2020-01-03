import { OperationVariables } from 'apollo-client';
import { pathOr } from 'ramda';
import useEventId from '../../queries/events/useEventId';
import useDatetimeQueryOptions from '../../queries/datetimes/useDatetimeQueryOptions';
import useOnCreateDatetime from './useOnCreateDatetime';
import useOnUpdateDatetime from './useOnUpdateDatetime';
import useOnDeleteDatetime from './useOnDeleteDatetime';
import {
	Mutator,
	MutationType,
	MutationInput,
	OnUpdateFnOptions,
	MutatorGeneratedObject,
} from '../../../../../application/services/apollo/mutations/types';
import { ReadQueryOptions } from '../../queries/types';
import { DEFAULT_ENTITY_LIST_DATA as DEFAULT_LIST_DATA } from '../../queries';
import { Datetime, DatetimeEdge } from '../../types';
import { DatetimeMutationCallbackFn } from '../types';

/**
 *
 */
const useDatetimeMutator = (): Mutator => {
	const eventId: number = useEventId();

	const options: ReadQueryOptions = useDatetimeQueryOptions();

	const onCreateDatetime: DatetimeMutationCallbackFn = useOnCreateDatetime();
	const onUpdateDatetime: DatetimeMutationCallbackFn = useOnUpdateDatetime();
	const onDeleteDatetime: DatetimeMutationCallbackFn = useOnDeleteDatetime();

	const createVariables = (mutationType: MutationType, input: MutationInput): OperationVariables => {
		const mutationInput: MutationInput = {
			clientMutationId: `${mutationType}_DATETIME`,
			...input,
		};

		if (mutationType === 'CREATE') {
			mutationInput.eventId = eventId; // required for createDatetime
		}

		return {
			input: mutationInput,
		};
	};

	const mutator = (mutationType: MutationType, input: MutationInput): MutatorGeneratedObject => {
		const variables: OperationVariables = createVariables(mutationType, input);
		/**
		 * @todo update optimisticResponse
		 */
		let optimisticResponse: any;

		const onUpdate = ({ proxy, entity: datetime }: OnUpdateFnOptions<Datetime>): void => {
			// Read the existing data from cache.
			let data: any;
			try {
				data = proxy.readQuery(options);
			} catch (error) {
				data = {};
			}
			const datetimes = pathOr<DatetimeEdge>(DEFAULT_LIST_DATA('Datetimes'), ['espressoDatetimes'], data);
			const { tickets = [] } = input;

			switch (mutationType) {
				case MutationType.Create:
					onCreateDatetime({ proxy, datetimes, datetime, tickets });
					break;
				case MutationType.Update:
					onUpdateDatetime({ datetime, tickets });
					break;
				case MutationType.Delete:
					onDeleteDatetime({ proxy, datetimes, datetime });
					break;
			}
		};

		return { variables, optimisticResponse, onUpdate };
	};

	return mutator;
};

export default useDatetimeMutator;
