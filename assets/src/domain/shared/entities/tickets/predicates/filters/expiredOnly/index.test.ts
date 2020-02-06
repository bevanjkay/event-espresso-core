import { formatISO, parseISO } from 'date-fns';

import expiredOnly from './index';
import { nodes as tickets } from '../../../../../../eventEditor/services/apollo/queries/tickets/test/data';
import { diff, add } from '../../../../../../../application/services/utilities/date';

describe('expiredOnly', () => {
	it('should return an empty array if tickets are trashed', () => {
		const updatedTickets = tickets.map((ticket) => ({ ...ticket, isTrashed: true }));
		const filteredTickets = expiredOnly(updatedTickets);
		expect(filteredTickets).toEqual([]);
	});

	it('should return an empty array if tickets are not expired', () => {
		const updatedTickets = tickets.map((ticket) => {
			const endDate = formatISO(add('weeks', new Date(), 1));
			return { ...ticket, endDate };
		});
		const filteredTickets = expiredOnly(updatedTickets);
		expect(filteredTickets).toEqual([]);
	});

	it('should return an array of expired tickets if ticket`s end date is past now', () => {
		const filteredTickets = expiredOnly(tickets);
		filteredTickets.forEach((ticket) => {
			const endDate = parseISO(ticket.endDate);
			const result = diff('minutes', endDate, new Date()) < 0;
			expect(result).toBe(true);
		});
	});
});
