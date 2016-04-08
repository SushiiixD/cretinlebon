#include "array.h"
#include <stdlib.h>
#include <stdio.h>
#include <string.h>
#include <sys/types.h>

void array_create(struct array *self) {
	self->capacity = 16;
	self->size = 0;
	self->data = malloc(self->capacity * sizeof(int));
}

void array_destroy(struct array *self) {
	free(self->data);
}

bool array_equals(const struct array *self, const int *content, size_t size) {
	if (self->size != size)
	{
		return false;
	}

	for(size_t i = 0; i < size; i++){
		if(self->data[i] != content[i])
		{
			return false;
		}		
	}
	return true;
}

void array_add(struct array *self, int value) {

	if(self->size == self->capacity)
	{
		self->capacity *= 3;
		int *data = malloc(self->capacity * sizeof(int));
		memcpy(data, self->data, self->size * sizeof(int));
		free(self->data);
		self->data = data;
	}
	
	self->data[self->size] = value;
	self->size++;
}

void array_insert(struct array *self, int value, size_t index) {
	if(self->size == self->capacity)
	{
		self->capacity *= 3;
		int *data = malloc(self->capacity * sizeof(int));
		memcpy(data, self->data, self->size * sizeof(int));
		free(self->data);
		self->data = data;
	}
	for(size_t i = self->capacity; i > index; i--)
	{
				self->data[i] = self->data[i-1];
	}
	self->data[index] = value;
	self->size++;
}

void array_remove(struct array *self, size_t index) {
	for(size_t i = index; i < self->size-1; i++)
	{
		self->data[i] = self->data[i+1];
	}
	self->size--;
}

int *array_get(const struct array *self, size_t index) {
	if(self->size <= index)
	{
		return NULL;
	}
	return &self->data[index];
}

bool array_is_empty(const struct array *self) {

  return self->size == 0;
}

size_t array_size(const struct array *self) {

  return self->size;
}

size_t array_search(const struct array *self, int value) {

  	for(size_t i = 0; i < self->size; i++)
  	{
		if (self->data[i] == value)
		{
			return i;
		}
	}
  	return self->size;
}

size_t array_binary_search(const struct array *self, size_t n, int e, size_t lo, size_t hi){
	if(lo == hi)
	{
		return n;
	}	

	size_t mid = (lo+hi)/2;
	if(e < self->data[mid])
	{
		return array_binary_search(self, n, e, lo, mid);
	}
		
	if(self->data[mid] < e)
	{
		return array_binary_search(self, n, e, mid + 1, hi);
	}	
	return mid;
}

size_t array_search_sorted(const struct array *self, int value) {

  return array_binary_search(self, self->size, value, 0, self->size);
}

void array_import(struct array *self, const int *other, size_t size) {
	self->size = 0;
	for(size_t i = 0; i < size; i++)
	{
		array_add(self, other[i]);
	}	
}

void array_dump(const struct array *self) {
	printf("[");
	for(size_t i = 0; i< self->size; i++)
	{
		printf("%i ",self->data[i]);
	}		
	printf("]\n");
}

bool array_is_sorted(const struct array *self) {

 	for(size_t i = 1; i < self->size; i++)
  	{
		if(self->data[i-1] > self->data[i])
		{
			return false;
		}		
	}
	return true;
}

void array_selection_sort(struct array *self) {
	int tmp;
	for(size_t i = 0; i < self->size-1; i++)
	{
		size_t j = i;
		for(size_t k = j+1; k < self->size; k++)
		{
			if(self->data[k] < self->data[j])
			{
				j = k;
			}
		}
		tmp = self->data[i];
		self->data[i] = self->data[j];
		self->data[j] = tmp;
	}
}

void array_bubble_sort(struct array *self) {
	int tmp;
	for(size_t i = 0; i < self->size - 1; i++)
	{
		for(size_t j = self->size-1; j > i; j--)
		{
			if(self->data[j] < self->data[j-1])
			{
				tmp = self->data[j];
				self->data[j] = self->data[j-1];
				self->data[j-1] = tmp;
			}
		}
	}
}

void array_insertion_sort(struct array *self) {
	for(size_t i = 1; i < self->size; i++)
	{
		int x = self->data[i];
		size_t j = i;
		while(j > 0 && self->data[j-1] > x)
		{
			self->data[j] = self->data[j-1];
			j--;
		}
		self->data[j] = x;
	}
}

ssize_t array_partition(struct array *self, ssize_t i, ssize_t j){
	ssize_t p = i;
	const int pivot = self->data[p];
	int tmp = self->data[p];
	self->data[p] = self->data[j];
	self->data[j] = tmp;
	ssize_t l = i;
	for(ssize_t k = i; k < j; k++)
	{
		if(self->data[k] < pivot)
		{
			tmp = self->data[k];
			self->data[k] = self->data[l];
			self->data[l] = tmp;
			l++;
		}
	}
	tmp = self->data[l];
	self->data[l] = self->data[j];
	self->data[j] = tmp;
	return l;
}

void array_quick_sort_partial(struct array *self, ssize_t i, ssize_t j){
	if(i < j)
	{
		ssize_t p = array_partition(self, i, j);
		array_quick_sort_partial(self, i, p-1);
		array_quick_sort_partial(self, p+1, j);
	}
}

void array_quick_sort(struct array *self) {
	array_quick_sort_partial(self, 0, self->size-1);
}

void array_heap_sort(struct array *self) {
	self->size = 0;
 	for (size_t i = 0; i < self->size; i++) 
 	{
		int value = self->data[i];
    array_heap_add(self, value);
  }
  for (size_t i = 0; i < self->size; i++) 
  {
    int value = self->data[0];
    array_heap_remove_top(self);
    self->data[self->size - i - 1] = value;
  }
}

void array_swap(int *data, size_t i, size_t j){
	int tmp = data[i];
	data[i] = data[j];
	data[j] = tmp;
}

bool array_is_heap(const struct array *self) {
  	self->data[0] = self->data[self->size - 1];
	size_t i = 0;
	size_t lt = 2 * i + 1;
	size_t rt = 2 * i + 2;
	if(self->data[i] > self->data[lt] && self->data[i] > self->data[rt])
	{
		return false;
	}			
	return true;
}


void heap_insert(int *heap, size_t n, int value) {
	size_t i = n;
	heap[i] = value;
	while (i > 0) {
		ssize_t j = (i - 1) / 2;
		if (heap[i] < heap[j]) {
			break;
		}
	array_swap(heap, i, j);
	i = j;
	}
}

void array_heap_add(struct array *self, int value) {
	if(self->size == self->capacity)
	{
		self->capacity *= 3;
		int *data = malloc(self->capacity * sizeof(int));
		memcpy(data, self->data, self->size * sizeof(int));
		free(self->data);
		self->data = data;
	}
	heap_insert(self->data,self->size,value);
	self->size++;
}

int array_heap_top(const struct array *self) {
	if (self->size >0)
	{
		return self->data[0];
	}
	return 0;
}



void heap_remove_max(int *heap, size_t n) {
	heap[0] = heap[n - 1];
	size_t i = 0;
	while (i < (n - 1) / 2) 
	{
		size_t lt = 2 * i + 1;
		size_t rt = 2 * i + 2;
		if (heap[i] > heap[lt] && heap[i] > heap[rt]) 
		{
			break;
		}
		size_t j = (heap[lt] > heap[rt]) ? lt : rt;
		array_swap(heap, i, j);
		i = j;
	}
}

void array_heap_remove_top(struct array *self) {
	heap_remove_max(self->data,self->size);
	self->size--;
}
