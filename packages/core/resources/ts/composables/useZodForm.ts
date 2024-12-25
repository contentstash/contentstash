import { z } from "zod";

export default function () {
  const { t } = useI18n();

  /**
   * Create a Zod schema for a string field
   */
  const createStringField = ({
    field,
  }: {
    field: FormSchemaInputString;
  }): z.ZodTypeAny => {
    let schema = z.string();
    if (field.required) {
      schema = schema.trim().min(1);
    }
    return schema;
  };

  /**
   * Create a Zod schema for a number field
   */
  const createNumberField = ({
    field,
  }: {
    field: FormSchemaInputNumber;
  }): z.ZodTypeAny => {
    let schema = z.number();
    if (field.min !== undefined) {
      schema = schema.min(field.min);
    }
    if (field.max !== undefined) {
      schema = schema.max(field.max);
    }
    return schema;
  };

  /**
   * Create a Zod schema for a boolean field
   */
  const createBooleanField = (): z.ZodTypeAny => {
    return z.boolean();
  };

  /**
   * Create a Zod schema for a date field
   */
  const createDateField = (): z.ZodTypeAny => {
    return z.coerce.date();
  };

  /**
   * Create a Zod schema for a field
   */
  const createField = ({ field }: { field: FormSchemaInput }): z.ZodTypeAny => {
    let zodField;

    // Create a Zod field based on the field type
    if (field.type == "string") {
      zodField = createStringField({ field });
    } else if (field.type == "number") {
      zodField = createNumberField({ field });
    } else if (field.type == "boolean") {
      zodField = createBooleanField();
    } else if (field.type == "date") {
      zodField = createDateField();
    } else {
      throw new Error(`Field ${field} is not supported`);
    }

    // set the default value and required status
    if (field.defaultValue !== undefined) {
      if (field.type === "date" && typeof field.defaultValue === "string") {
        zodField = zodField.default(new Date(field.defaultValue));
      } else {
        zodField = zodField.default(field.defaultValue);
      }
    }

    if (!field.required) {
      zodField = zodField.optional();
    }

    zodField = zodField.describe(field.label);

    return zodField;
  };

  /**
   * Create a Zod schema for a form schema
   */
  const createZodSchema = (
    schema: FormSchema,
  ): z.ZodObject<Record<string, z.ZodTypeAny>> => {
    const shape = Object.fromEntries(
      Object.entries(schema).map(
        ([key, field]: [string, FormSchemaInput]): [string, z.ZodTypeAny] => [
          key,
          createField({ field }),
        ],
      ),
    );

    return z.object(shape);
  };

  /**
   * Validate a form schema
   */
  const validateSchema = ({ schema }: { schema: FormSchema }): boolean => {
    try {
      createZodSchema(schema);
    } catch (error) {
      console.error("Validation failed:", error);
      return false;
    }
    return true;
  };

  /**
   * Generate a Zod schema and field configuration from a form schema
   */
  const generateSchema = ({
    schema,
  }: {
    schema: FormSchema;
  }): {
    schema: z.ZodObject<Record<string, z.ZodTypeAny>>;
    fieldConfig: Record<
      string,
      { label?: string; description?: string; placeholder?: string }
    >;
  } => {
    const zodSchema = createZodSchema(schema);
    const fieldConfig = Object.fromEntries(
      Object.entries(schema).map(([key, field]) => [
        key,
        {
          label: t(field.label),
          description: field?.description ? t(field.description) : undefined,
          component: field?.component ?? undefined,
          inputProps: {
            type: field.type,
            placeholder: field?.placeholder ? t(field.placeholder) : undefined,
          },
        },
      ]),
    );

    return { schema: zodSchema, fieldConfig };
  };

  return {
    createZodSchema,
    validateSchema,
    generateSchema,
  };
}
