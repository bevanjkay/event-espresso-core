import { DatetimeBaseInput } from '@edtrServices/apollo/mutations';
import { DateAndTime } from '../../../../shared/services/utils/dateAndTime';

export interface DateFormShape extends DatetimeBaseInput, DateAndTime {
	name?: string;
	description?: string;
	capacity?: number;
	dateTime?: DateAndTime;
	isTrashed?: boolean;
}