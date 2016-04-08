#include "list.h"
#include <stdio.h>
#include <stdlib.h>

struct list_node {
  int value;
  struct list_node *next;
  // struct list_node *prev;
};

void list_create(struct list *self) {
	self->first = NULL;
}

void list_destroy(struct list *self) {
	struct list_node *current = self->first;
	struct list_node* next;
	while(current)
	{
		next = current->next;
		free(current);
		current = next;
	}
	self->first = NULL;
}

bool list_equals(const struct list *self, const int *data, size_t size) {

	bool test = true;
	size_t cpt = 0;
	if (!self->first || !data)
	{
		return self->first && data;
	}
	struct list_node *current = self->first;
	while(current && cpt < size)
	{
		test = test && (current->value == data[cpt]);
		current = current->next;
		cpt++;
	}
	return test;
}

void list_add_back(struct list *self, int value) {
	struct list_node *node = malloc(sizeof(struct list_node));
    node->value = value;
    node->next = NULL;

    if (!self->first)
    {
    	self->first = node;
    }else 
    {
    	struct list_node *current = self->first;
    	while(current->next)
    	{
      		current = current->next;
      	}
    	current->next = node;
	}
}

void list_add_front(struct list *self, int value) {
  	struct list_node *current = self->first;
	struct list_node *node = malloc(sizeof(struct list_node));
	node->value = value;
	self->first = node;
	node->next = current;
}

void list_insert(struct list *self, int value, size_t index) {
	struct list_node *node = malloc(sizeof(struct list_node));
	node->value = value;
	
	struct list_node *current = NULL;
	if(index == 0)
	{
		current = self->first;
		self->first = node;
		node->next = current;
	}
	else
	{
		size_t cpt = 0;
		struct list_node *prev = self->first;
		current = self->first;
		
		while(cpt != index && current)
		{
			prev = current;
			current = current->next;
			cpt++;
		}
		prev->next = node;
		node->next = current;
	}
}

void list_remove(struct list *self, size_t index) {
	int cpt = 0;
	struct list_node *current = self->first;
	struct list_node *prev = self->first;
	
	if(index == 0)
	{
		self->first = current->next;
		free(current);
	}
	else
	{
		while(cpt != index)
		{
			prev = current;
			current = current->next;
			cpt++;
		}
		prev->next = current->next;
		free(current);
	}
}

int *list_get(const struct list *self, size_t index) {

  	int cpt = 0;
	struct list_node *current = self->first;
	while(cpt != index)
	{
		current = current->next;
		cpt++;
	}	
  	return &current->value;
}

bool list_is_empty(const struct list *self) {

   return !self->first;
}

size_t list_size(const struct list *self) {

  	size_t cpt = 0;
	struct list_node *current = self->first;	
	while(current)
	{
		current = current->next;
		cpt++;
	}
 	return cpt;
}

size_t list_search(const struct list *self, int value) {

  	size_t cpt = 0;
	struct list_node *current = self->first;
	while(current)
	{
		if (current->value == value)
		{
			return cpt;
		}
		current = current->next;
		cpt++;
	}
	return cpt;
}

void list_import(struct list *self, const int *other, size_t size) {
	if(!other || size == 0)
	{
		self->first = NULL;
	}
	else
	{
		self->first = malloc(sizeof(struct list_node));
		struct list_node *current = self->first;
		current->value = other[0];
		current->next = NULL;

		for(size_t i = 1; i < size; i++)
		{
			current->next = malloc(sizeof(struct list_node));
			current = current->next;
			current->value = other[i];
			current->next = NULL;
		}
	}
}

void list_dump(const struct list *self) {
	struct list_node *current = self->first;
	while(current)
	{
		fprintf(stdout, "%d ", current->value);
		current = current->next;
	}
	fprintf(stdout, "\n");
}

bool list_is_sorted(const struct list *self) {
  	bool sorted = true;
	if(self->first && self->first->next)
	{
		struct list_node *current = self->first;

		while(current->next && sorted)
		{
			sorted = current->value <= current->next->value;
			current = current->next;
		}
	}
	return sorted;
}

struct list_node * list_sorted_merge(struct list_node *a, struct list_node *b){
	struct list_node *result = NULL;
	if(!a)
	{
		return b;
	}  

	if(!b)
	{
	  	return a;
	} 

	if(a->value < b->value)
	{
	    result = a;
	    result->next = list_sorted_merge(a->next, b);
	}
	else
	{
	    result = b;
	    result->next = list_sorted_merge(a, b->next);
	}

	return result;
}

struct list_node * list_node_merge_sort(struct list_node *self){
  struct list_node *a;
  struct list_node *b;

  if(!self || !self->next)
  {
  	return self;
  }

  a = self;
  b = self->next;

  while(b && b->next)
  {
  	self = self->next;
    b = self->next->next;
  }
  b = self->next;
  self->next = NULL;

  return list_sorted_merge(list_node_merge_sort(a), list_node_merge_sort(b));
}

void list_merge_sort(struct list *self) {
	if(self && self->first)
	{
		self->first = list_node_merge_sort(self->first);
	}
}
