import { z } from "zod";

export default function () {
  const { t } = useI18n();

  const createZodSchema = (schema: FormSchema) => {
    const shape = Object.fromEntries(
      Object.entries(schema).map(
        ([key, field]: [string, FormSchemaInput]): [string, z.ZodTypeAny] => {
          let zodField;

          switch (field.type) {
            case "string":
              zodField = z.string();
              if (field.default !== undefined)
                zodField = zodField.default(field.default);
              break;

            case "number":
              zodField = z.number();
              if (field.min !== undefined) zodField = zodField.min(field.min);
              if (field.max !== undefined) zodField = zodField.max(field.max);
              if (field.default !== undefined)
                zodField = zodField.default(field.default);
              break;

            case "boolean":
              zodField = z.boolean();
              if (field.default !== undefined)
                zodField = zodField.default(field.default);
              break;

            case "date":
              zodField = z.date();
              if (field.default !== undefined) {
                zodField = zodField.default(
                  typeof field.default === "string"
                    ? new Date(field.default)
                    : field.default,
                );
              }
              break;

            case "enum":
              zodField = z.enum(field.options as [string, ...string[]]);
              if (field.default !== undefined)
                zodField = zodField.default(field.default);
              break;

            case "array":
              zodField = z.array(createZodSchema({ item: field.items }));
              if (field.default !== undefined)
                zodField = zodField.default(field.default);
              break;

            default:
              throw new Error(`Unsupported field type: ${field.type}`);
          }

          if (!field?.required) {
            zodField = zodField.optional();
          }

          zodField = zodField.describe(t(field.label));

          return [key, zodField];
        },
      ),
    );

    return z.object(shape);
  };

  return {
    validateSchema: ({ schema }: { schema: FormSchema }): boolean => {
      try {
        createZodSchema(schema);
      } catch (error) {
        console.error("Validation failed:", error);
        return false;
      }
      return true;
    },

    generateSchema: ({
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
              placeholder: field?.placeholder
                ? t(field.placeholder)
                : undefined,
            },
          },
        ]),
      );

      return { schema: zodSchema, fieldConfig };
    },
  };
}
