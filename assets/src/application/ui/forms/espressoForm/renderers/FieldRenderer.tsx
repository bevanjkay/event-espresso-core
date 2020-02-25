import React from 'react';
import classNames from 'classnames';

import { FormItem, MappedField } from '../adapters';
import { FieldRendererProps } from '../types';
import { getValidateStatus } from '../utils';
import useFormItemLayout from '../hooks/useFormItemLayout';

const FieldRenderer: React.FC<FieldRendererProps> = (props) => {
	const { label, desc, required, meta, before, after, formItemProps, ...rest } = props;

	const formItemLayout = useFormItemLayout();

	// no layout stuff needed for hidden field
	if (props.fieldType === 'hidden') {
		return <MappedField {...rest} />;
	}

	const validateStatus = getValidateStatus(meta);
	return (
		<FormItem
			label={label}
			extra={desc}
			required={required}
			validateStatus={validateStatus}
			hasFeedback={meta.touched && !!(meta.error || meta.submitError)}
			help={meta.touched && (meta.error || meta.submitError)}
			{...formItemLayout}
			{...formItemProps}
			className={classNames('form-item', `form-item-${rest.fieldType}`, formItemProps?.className)}
		>
			<>
				{before}
				<MappedField {...rest} />
				{after}
			</>
		</FormItem>
	);
};
export default FieldRenderer;