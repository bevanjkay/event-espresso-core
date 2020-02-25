import React from 'react';

/**
 * @function
 * @param {Object|string} heading
 * @param {Object|string} value
 * @return {Object} rendered headings row
 */
const ResponsiveCell = ({ heading, value }) => {
	return (
		<>
			<div aria-hidden className={'ee-rspnsv-table-mobile-only-column-header'}>
				{heading}
			</div>
			<div className={'ee-rspnsv-table-mobile-only-column-value'}>{value}</div>
		</>
	);
};

// ResponsiveCell.propTypes = {
// 	heading: PropTypes.node,
// 	value: PropTypes.node,
// };

// ResponsiveCell.defaultProps = {
// 	heading: '',
// 	value: '',
// };

export default ResponsiveCell;